<?php namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Games
 * @property integer $user_id
 * @property boolean $is_win
 * @property User $user
 * @package App
 */
class Games extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'user_id',
        'is_win'
    ];

    public static $validator = [
        'is_win'=>'array',
        'user_id'=>'required|integer|exists:users,id'
    ];

    public function setData ($data) {
        if (is_array($data)) {
            $this->user_id = $data['user_id'];
            $this->is_win = $data['isWin'];
            return true;
        }
        return false;

    }

    public function user()
    {
        return $this->hasOne('app\User', 'id', 'user_id');
    }

}
