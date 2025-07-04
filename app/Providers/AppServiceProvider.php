<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            if ($user instanceof \Illuminate\Database\Eloquent\Model) {
                $user->load(['persona', 'role']);
            }
            $view->with('user', $user);
        });
    }
}
