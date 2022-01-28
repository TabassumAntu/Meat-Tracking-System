<?php

namespace App\Providers;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $roleRepository = $this->app->make(RoleRepositoryInterface::class);

        $roles = $roleRepository->getRolesView();

        View::composer('auth.register', function ($view) use($roles) {
           $view->with('roles', $roles);
        });
    }
}
