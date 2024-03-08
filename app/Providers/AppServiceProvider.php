<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultstringLength(191);
        // Gate::define('admin', function(User $user) {
        //     return $user->id == 1;
        // });
        // Gate::define('super_admin', function(User $user) {
        //     return $user->id == 12;
        // });
        // Gate::define('manager', function(User $user) {
        //     return $user->id == 12;
        // });
    }
}
