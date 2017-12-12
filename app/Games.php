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
