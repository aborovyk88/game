<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
            'updated_at' => 'Updated At'
        ];
    }

    public static $validatorCreate = [
        'name'=>'required|string',
        'email'=>'required|email|unique:users,email'
    ];

    public static $validatorUpdate = [
        'name'=>'required|string',
        'email'=>'required|email'
    ];

    public static function getAttributeLabel ($attribute) {
        if (isset(self::attributeLabels()[$attribute])) {
            return self::attributeLabels()[$attribute];
        }
        return null;
    }

    public static function getAttributeLabels () {
        $data = [];
        foreach (self::attributeLabels() as $label) {
            $data[] = $label;
        }
        return $data;
    }

    public static function getDataLabels($users_array) {
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

    public function games()
    {
        return $this->hasMany('App\Games', 'user_id');
    }
}