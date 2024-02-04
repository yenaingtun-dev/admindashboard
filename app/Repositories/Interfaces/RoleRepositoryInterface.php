<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface
{
      public function all();
      public function find($id);
      public function store($data);
      public function storeBranch($data);
      public function update($data, $user);
      public function updateBranch($data);
      public function softDelete($user);
      public function forceDelete($user);
      public function assignPermission($permissionInputs, $role);
}
