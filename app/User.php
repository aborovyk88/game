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

    public static function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'E`mail',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'amount' => 'Amount'
        ];
    }

    public static function getAttributeLabel ($attribute) {
        if (isset(self::attributeLabels()[$attribute])) {
            return self::attributeLabels()[$attribute];
        }
        return null;
    }

    /**
     * Get attribute label for column title table users
     *
     * @return array
     */
    public static function getAttributeLabels () {
        $data = [];
        foreach (self::attributeLabels() as $label) {
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
    public static function getDataLabels(array $users_array) {
        $data = [];
        foreach ($users_array as $user) {
            $temp = [];
            foreach ($user as $attribute => $value) {
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
    public static function getPaginateData ($current_page = 0, $per_page = 10) {
        /** @var Collection $users */
        $users = self::orderBy('amount', 'desc')->get();
        $array_users = $users->chunk($per_page);
        $page_count = $array_users->count();
        $array_users = $array_users->get($current_page)->toArray();
        return [
            'count' => $page_count,
            'data' => self::getDataLabels($array_users)
        ];
    }

    /**
     * increment or decrement amount user
     *
     * @param boolean $is_win
     * @return bool
     */
    public function updateAmount ($is_win) {
        if ($is_win) {
            $this->amount -= self::GAME_AMOUNT;
        } else {
            $this->amount += self::GAME_AMOUNT;
        }
        return $this->update();
    }

    /**
     * Generate random password user for create in frontend
     */
    public function generatePassword () {
        $pass = bcrypt(str_random(6));
        $this->password = $pass;
    }

    /**
     * Get games relation with user [id => user_id]
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games()
    {
        return $this->hasMany('App\Games', 'user_id');
    }
}