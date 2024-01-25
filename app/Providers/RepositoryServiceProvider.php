<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;

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
