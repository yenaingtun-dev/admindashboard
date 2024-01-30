<?php

namespace App\Repositories\Interfaces;

interface BranchRepositoryInterface
{
      public function all();
      public function find($id);
      public function store($data);
      public function update($data, $branch);
      public function softDelete($branch);
      public function forceDelete($branch);
}
