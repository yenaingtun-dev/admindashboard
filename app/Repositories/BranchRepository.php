<?php

namespace App\Repositories;

use App\Helpers\helper\helper;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\BranchRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class BranchRepository implements BranchRepositoryInterface
{
      public $roleRepository, $permissionRepository;
      public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
      {
          $this->roleRepository = $roleRepository;
          $this->permissionRepository = $permissionRepository;
      }


      public function all(): Collection
      {
            return Branch::all();
      }

      public function find($id)
      {
            return $this->all()->find($id);
      }

      public function store($data)
      {
            $id = Branch::create($data)->id;
            $branch = [
                  'id' => $id,
                  'name' => $data['name']
            ];
            $this->roleRepository->storeBranch($branch);
            $this->permissionRepository->storeBranch($branch);
      }

      public function update($data, $branch)
      {
            $branch->update($data);
            $this->roleRepository->updateBranch($branch);
      }

      public function softDelete($branch)
      {
            $branch->delete();
      }

      public function forceDelete($branch)
      {
            $branch->forceDelete();
      }
}
