<?php namespace App;

use Zizaco\Entrust\EntrustPermission;

/**
 * Class Permission
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @package App
 * @mixin \Eloquent
 */
class Permission extends EntrustPermission
{
    const PERMISSION_USER_EDIT = 'user-create';
    const PERMISSION_USER_LIST = 'user-list';
    const PERMISSION_USER_DELETE = 'user-delete';

    const PERMISSION_GAME_LIST = 'game-list';
    const PERMISSION_GAME_EDIT = 'game-create';
    const PERMISSION_GAME_DELETE = 'game-DELETE';

    protected $table = 'permission';

    protected $fillable = [
        'id', 'name', 'display_name', 'description', 'created_at', 'updated_at',
    ];


    public static function addPermission(string $name, string $display_name = null, string $description = null) {
        $model = new self();
        $model->name = $name;
        $model->display_name = $display_name;
        $model->description = $description;
        if($model->save()) {
            return $model;
        } else return false;
    }
}