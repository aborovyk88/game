<?php namespace App;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait TListingData
 * @package App
 */
trait TListingData
{

    private static $ORDER_ASC = 1;
    private static $ORDER_DESC = -1;


    /**
     * @return array
     */
    public static function orderKeys(): array {
        return [
            self::$ORDER_ASC => 'asc',
            self::$ORDER_DESC => 'desc',
        ];
    }


    /**
     * @param string $attribute
     * @return string|null
     */
    public static function getAttributeLabel(string $attribute): string {
        return self::attributeLabels()[$attribute] ?? null;
    }


    /**
     * Get attribute label for column title table
     *
     * @return array
     */
    public static function getColumnLabels(): array {
        return array_values(self::attributeLabels());
    }


    /**
     * Get model data with attribute labels
     *
     * @param array $models_array
     * @return array
     */
    public static function getDataLabels(array $models_array): array {
        $data = [];
        foreach($models_array as $model) {
            $temp = [];
            foreach($model as $attribute => $value) {
                $label = self::getAttributeLabel($attribute);
                if(!empty($label)) {
                    $temp[$label] = $value;
                }
            }
            $data[] = $temp;
        }
        return $data;
    }


    /**
     * Get models data chunk
     *
     * @param array $request
     * @return array
     */
    public static function getData(array $request): array {
        /** @var Builder $query */
        $query = self::query();
        foreach($request['filters'] as $key => $value) {
            $column = self::prepareFilterKey($key);
            if(!empty($column) && !empty($value)) {
                $query = $query->where($column, 'LIKE', $value . '%');
            }
        }
        foreach($request['orders'] as $key => $value) {
            $column = self::prepareFilterKey($key);
            if(!empty($column) && $value == self::$ORDER_DESC) {
                $value = self::prepareOrderValue($value);
                $query = $query->orderBy($column, $value);
            }
        }
        $count = $query->count();
        $models = $query->forPage($request['currentPage'], $request['perPage'])
                        ->get();
        if(!$models->isEmpty()) {
            $countPages = ceil($count / $request['perPage']);
            $array_models = $models->toArray();
            return [
                'count' => $countPages,
                'data' => self::getDataLabels($array_models),
            ];
        }
        return [
            'count' => 0,
            'data' => [],
        ];
    }


    /**
     * Get column name for where statement with attribute label
     *
     * @param string $key
     * @return string
     */
    public static function prepareFilterKey(string $key): string {
        $flip_labels = array_flip(self::attributeLabels());
        return $flip_labels[$key] ?? null;
    }


    /**
     * Get sort key
     *
     * @param int $value
     * @return string
     */
    public static function prepareOrderValue(int $value): string {
        return self::orderKeys()[$value] ?? self::orderKeys()[self::$ORDER_ASC];
    }
}