<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // user
        Schema::disableForeignKeyConstraints();
        User::truncate();
        $users =  [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@mail.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('password'),
            ],
        ];
        User::insert($users);
        // role
        Role::truncate();
        $roles =  [['title' => 'super_admin',], ['title' => 'admin',],];
        Role::insert($roles);
        // permission
        Permission::truncate();
        $permissions = [
            ['title' => 'create_user'], ['title' => 'create_role'], ['title' => 'create_permission'], ['title' => 'edit_user'], ['title' => 'edit_role'], ['title' => 'edit_permission'], ['title' => 'delete_user'], ['title' => 'delete_role'], ['title' => 'delete_permission'],['title' => 'create_branch'], ['title' => 'edit_branch'], ['title' => 'delete_branch']
        ];
        Permission::insert($permissions);
        // permission role
        $administrator_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($administrator_permissions->pluck('id'));
        $admin_permissions = $administrator_permissions->filter(function ($permission) {
            return $permission->title != 'create_permission' && $permission->title != 'edit_permission' && $permission->title != 'delete_permission' && $permission->title != 'create_branch' && $permission->title != 'edit_branch' && $permission->title != 'delete_branch' && $permission->title != 'edit_role' && $permission->title != 'delete_role' && $permission->title != 'delete_user' && $permission->title != 'edit_user';
        });
        Role::findOrFail(2)->permissions()->sync($admin_permissions);
        // role user
        User::findOrFail(1)->roles()->sync(1);
        User::findOrFail(2)->roles()->sync(2);
        Schema::enableForeignKeyConstraints();
    }
}
