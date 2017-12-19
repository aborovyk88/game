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
 */
class Games extends Model
{
    use Notifiable;

    protected $fillable = [
        'user_id',
        'is_win',
    ];


    /**
     * get user with game
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user() {
        return $this->hasOne('app\User', 'id', 'user_id');
    }

}
