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
    public static function getAttributeLabels(): array {
        $data = [];
        foreach(self::attributeLabels() as $label) {
            $data[] = $label;
        }
        return $data;
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
                $temp[self::getAttributeLabel($attribute)] = $value;
            }
            $data[] = $temp;
        }
        return $data;
    }


    /**
     * Get models data chunk
     *
     * @param int $current_page
     * @param int $per_page
     * @param array $filters
     * @param array $orders
     * @return array
     */
    public static function getPaginateData(int $current_page = 0,
                                           int $per_page = 10,
                                           array $filters = [],
                                           array $orders = []): array {
        /**
         * @var Builder $query
         */
        $current_page = self::processCurrentPage($current_page);
        $query = self::query();
        foreach($filters as $key => $value) {
            $column = self::prepareFilterKey($key);
            if(!empty($column) && !empty($value)) {
                $query = $query->where($column, 'LIKE', $value . '%');
            }
        }
        foreach($orders as $key => $value) {
            $column = self::prepareFilterKey($key);
            if(!empty($column) && $value == self::$ORDER_DESC) {
                $value = self::prepareOrderValue($value);
                $query = $query->orderBy($column, $value);
            }
        }
        $models = $query->get();
        if(!$models->isEmpty()) {
            $array_models = $models->chunk($per_page);
            $page_count = $array_models->count();
            $array_models = $array_models->get($current_page)->toArray();
            return [
                'count' => $page_count,
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
        return self::orderKeys()[$value] ?? self::$ORDER_ASC;
    }


    /**
     * Get formatted current grid page
     *
     * @param $current_page
     * @return int
     */
    public static function processCurrentPage(int $current_page): int {
        $current_page--;
        return $current_page < 0 ? 0 : $current_page;
    }

}