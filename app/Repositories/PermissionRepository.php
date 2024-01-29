<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
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
            $role = Permission::create($data);
            return $role;
      }

      public function update($data, $role)
      {
            $role->update($data);
            $role->save();
            return $role;
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
