<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Games
 * @property integer $id
 * @property integer $user_id
 * @property boolean $is_win
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @package App
 * @mixin \Eloquent
 */
class Games extends Model implements IListingData
{
    use Notifiable, TListingData;

    const GAME_AMOUNT = 10;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'is_win',
    ];


    /**
     * @return array
     */
    public static function attributeLabels(): array {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'is_win' => 'Is User Win',
            'created_at' => 'Created',
            'updated_at' => 'Updated'
        ];
    }


    /**
     * get user with game
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user() {
        return $this->hasOne('app\User', 'id', 'user_id');
    }
}
