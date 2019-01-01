<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      //string
        Schema::defaultStringLength(191);
        Gate::define('is_admin', function ($user) {
            if ($user->role == config('user.role.teacher')  || $user->role == config('user.role.admin') ){
                return true;
            }
          });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
