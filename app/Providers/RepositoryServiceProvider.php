<?php

namespace App\Providers;

use App\Repositories\BranchRepository;
use App\Repositories\Interfaces\BranchRepositoryInterface;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PermissionRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
      /**
       * Register services.
       *
       * @return void
       */
      public function register()
      {
            $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
            $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
            $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
            $this->app->bind(BranchRepositoryInterface::class, BranchRepository::class);
      }

      /**
       * Bootstrap services.
       *
       * @return void
       */
      public function boot()
      {
            //
      }
}
