<?php

namespace App\Providers;

use App\Service\SessionAccount;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $account = SessionAccount::GetSession();
            $view->with('account', $account);
        });


        View::composer('role-permission.permissions.list', function ($view) {
            $permissions = Permission::all();
            $view->with('permissions', $permissions);

            $roles = Role::all();
            $view->with('roles', $roles);
        });


        View::composer('role-permission.permissions.create', function ($view) {
            $permission = Permission::all();
            $view->with('permission', $permission);

            $roles = Role::all();
            $view->with('roles', $roles);
        });

        View::composer('role-permission.roles.list', function ($view) {
            $roles = Role::all();
            $view->with('roles', $roles);
        });

        View::composer('role-permission.roles.create', function ($view) {
            $roles = Role::all();
            $view->with('roles', $roles);
        });
    }
}
