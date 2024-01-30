<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
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
            return Role::create($data);
      }

      public function update($data, $role)
      {
            $roleData = ['title'=>$data['title']];
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
          if(count($permissionInputs) > 0) {
              foreach ($permissionInputs as $key => $value) {
                  array_push($permissions, $value);
              }
          }
          $role->permissions()->sync($permissions);
      }
}
