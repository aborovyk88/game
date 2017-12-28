<?php namespace App;

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
 * @mixin \Eloquent
 */
class User extends Authenticatable implements IListingData
{
    use Notifiable, TListingData;

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
     * Increment or decrement amount user
     *
     * @param boolean $is_win
     * @return bool
     */
    public function updateAmount(bool $is_win): bool {
        if($is_win) {
            $this->amount -= Games::GAME_AMOUNT;
        }
        else {
            $this->amount += Games::GAME_AMOUNT;
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