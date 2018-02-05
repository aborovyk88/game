<?php namespace App;

use Zizaco\Entrust\EntrustRole;

/**
 * Class Role
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @package App
 * @mixin \Eloquent
 */
class Role extends EntrustRole
{

    const ROLE_ADMIN = 'admin';
    const ROLE_GAMER = 'gamer';

    protected $table = 'roles';

    protected $fillable = [
        'id', 'name', 'display_name', 'description', 'created_at', 'updated_at',
    ];


    public static function addRole(string $name, string $display_name = null, string $description = null) {
        $model = new self();
        $model->name = $name;
        $model->display_name = $display_name;
        $model->description = $description;
        if($model->save()) {
            return $model;
        } else return false;
    }
}