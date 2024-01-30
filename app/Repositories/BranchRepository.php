<?php

namespace App\Repositories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\BranchRepositoryInterface;

class BranchRepository implements BranchRepositoryInterface
{
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
            return Branch::create($data);
      }

      public function update($data, $branch)
      {
            return $branch->update($data);
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
