<?php namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Role;
use App\Permission;

/**
 * Class MakeRoles
 * @package App\Console\Commands
 */
class MakeRoles extends Command
{
    protected $signature = 'roles';

    protected $description = 'Generate Roles';


    public function handle() {

//        Permission::truncate();
//        Role::truncate();


        $gamer = Role::addRole('gamer');
        $admin = Role::addRole('admin', 'User Administrator', 'User is allowed to manage and edit other users');

        $userListPerm = Permission::addPermission('user-list', 'User List');
        $userCreatePerm = Permission::addPermission('user-create', 'User Edit');
        $userDeletePerm = Permission::addPermission('user-delete', 'User Edit');

        $gameListPerm = Permission::addPermission('game-list', 'Game List');
        $gameCreatePerm = Permission::addPermission('game-create', 'Game Edit');
        $gameDeletePerm = Permission::addPermission('game-delete', 'Game Edit');

        $admin->attachPermission($userListPerm);
        $admin->attachPermission($userCreatePerm);
        $admin->attachPermission($userDeletePerm);

        $admin->attachPermission($gameListPerm);
        $admin->attachPermission($gameCreatePerm);
        $admin->attachPermission($gameDeletePerm);

        $gamer->attachPermission($userListPerm);
        $gamer->attachPermission($gameListPerm);

        $users = User::all();

        foreach($users as $user) {
            /** @var $user User */

            $user->attachRole($gamer);
        }
    }
}
