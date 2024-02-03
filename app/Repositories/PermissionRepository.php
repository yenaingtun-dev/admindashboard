<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Helpers\helper\helper;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{

      public $roleRepository;
      public function __construct(RoleRepositoryInterface $roleRepository)
      {
          $this->roleRepository = $roleRepository;
      }

      public function all(): Collection
      {
            return Permission::all();
      }

      public function find($id)
      {
            return $this->all()->find($id);
      }

      public function store($data)
      {
            if (isset($data['id'])) {
                  $permission =  Permission::create([
                        'title' => $data['name'] . ' permission_branch',
                        'branch_id' => $data['id'],
                        'branch_permission_slug' => $data['name'] . ' branch_permission_slug'
                  ]);
                  $superAdmin = helper::getUserAdmin('super_admin');
                  $permissions = [$permission->id];
                  $this->roleRepository->assignPermission($permissions, $superAdmin);
                  return $permission;
            } else {
                  return Permission::create($data);
            }
      }

      public function storeBranch($data)
      {
            $permission =  Permission::create([
                  'title' => $data['name'] . ' permission_branch',
                  'branch_id' => $data['id'],
                  'branch_permission_slug' => $data['name'] . ' branch_permission_slug'
            ]);
            $superAdmin = helper::getUserAdmin('super_admin');
            $superAdminPermissions = $superAdmin->permissions()->all();
            foreach ($superAdminPermissions as $value) {
                  $superPermissions[] = $value;
            }
            $adminPermissions[] = $permission->id;
            $superPermissions[] = $permission->id;
            $permissions[] = [$adminPermissions, $superPermissions];
            $roles = $superAdmin->roles;
            $this->roleRepository->assignPermission($permissions, $roles);
            return $permission;
      }

      public function update($data, $permission)
      {
            return $permission->update($data);
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
}
