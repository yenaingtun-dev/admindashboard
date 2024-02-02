<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Helpers\helper\helper;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{

      public $userRepository;
      public function __construct(UserRepositoryInterface $userRepository)
      {
            $this->userRepository = $userRepository;
      }

      public function all(): Collection
      {
            return Role::all();
      }

      public function find($id)
      {
            return $this->all()->find($id);
      }

      public function store($data)
      {
            if (isset($data['id'])) {
                  $role = Role::create([
                        'title' => $data['name'] . ' role_branch',
                        'branch_id' => $data['id'],
                        'branch_role_slug' => $data['name'] . ' branch_role_slug'
                  ]);
                  $superAdmin = helper::getUserAdmin('super_admin');
                  $roles[] = $role->id;
                  $this->userRepository->assignRole($roles, $superAdmin);
                  return $role;
            } else {
                  return Role::create([
                        'title' => $data['title']
                  ]);
            }
      }

      public function storeBranch($data)
      {
            $role = Role::create([
                  'title' => $data['name'] . ' role_branch',
                  'branch_id' => $data['id'],
                  'branch_role_slug' => $data['name'] . ' branch_role_slug'
            ]);
            $superAdmin = helper::getUserAdmin('super_admin');
            $superAdminRoles = $superAdmin->roles()->get();
            foreach ($superAdminRoles as $value) {
                  $roles[] = $value->id;
            }
            $roles[] = $role->id;
            $this->userRepository->assignRole($roles, $superAdmin);
            return $role;
      }

      public function update($data, $role)
      {
            $roleData = ['title' => $data['title']];
            return $role->update($roleData);
      }

      public function softDelete($user)
      {
            $user->delete();
      }

      public function forceDelete($user)
      {
            $user->forceDelete();
      }

      public function restore($id)
      {
            $this->all()->withTrashed()->find($id)->restore();
      }

      public function restoreAll()
      {
            $this->all()->onlyTrashed()->restore();
      }

      public function assignPermission($permissionInputs, $role)
      {
            $permissions = [];
            $superPermission = [];
            if (count($permissionInputs) > 0) {
                  foreach ($permissionInputs as $permissionInput) {
                        if (is_array($permissionInput)) {
                              foreach ($permissionInput[1] as $value) {
                                    array_push($superPermission, $value);
                              }
                              foreach ($permissionInput[0] as $value) {
                                    // array_push($superPermission, $value);
                                    array_push($permissions, $value);
                              }
                        } else {
                              array_push($permissions, $permissionInput);
                        }
                  }
            }
            if (isset($role[0])) {
                  foreach ($role as $value) {
                        if ($value->title == 'super_admin') {
                              $value->permissions()->sync($superPermission);
                        } else {
                              $value->permissions()->sync($permissions);
                        }
                  }
            } else {
                  $role->permissions()->sync($permissions);
            }
      }
}
