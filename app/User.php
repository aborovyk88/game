<?php namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property double $amount
 * @property Games[] $games
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    const GAME_AMOUNT = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'amount',
    ];

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * @return array
     */
    public static function attributeLabels(): array {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'E`mail',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'amount' => 'Amount',
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
     * Get attribute label for column title table users
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
     * Get users data with attribute labels
     *
     * @param array $users_array
     * @return array
     */
    public static function getDataLabels(array $users_array): array {
        $data = [];
        foreach($users_array as $user) {
            $temp = [];
            foreach($user as $attribute => $value) {
                $temp[User::getAttributeLabel($attribute)] = $value;
            }
            $data[] = $temp;
        }
        return $data;
    }


    /**
     * Get users data chunk
     *
     * @param int $current_page
     * @param int $per_page
     * @return array
     */
    public static function getPaginateData(int $current_page = 0, int $per_page = 10): array {
        /** @var Collection $users */
        $current_page = self::processCurrentPage($current_page);
        $users = self::orderBy('amount', 'desc')->get();
        $array_users = $users->chunk($per_page);
        $page_count = $array_users->count();
        $array_users = $array_users->get($current_page)->toArray();
        return [
            'count' => $page_count,
            'data' => self::getDataLabels($array_users),
        ];
    }


    /**
     * @param $current_page
     * @return int
     */
    public static function processCurrentPage(int $current_page): int {
        $current_page--;
        return $current_page < 0 ? 0 : $current_page;
    }


    /**
     * increment or decrement amount user
     *
     * @param boolean $is_win
     * @return bool
     */
    public function updateAmount(bool $is_win): bool {
        if($is_win) {
            $this->amount -= self::GAME_AMOUNT;
        }
        else {
            $this->amount += self::GAME_AMOUNT;
        }
        return $this->update();
    }


    /**
     * Generate random password user for create in frontend
     */
    public function generatePassword() {
        $this->password = bcrypt(random_bytes(6));
    }


    /**
     * Get games relation with user [id => user_id]
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games() {
        return $this->hasMany('App\Games', 'user_id');
    }
}