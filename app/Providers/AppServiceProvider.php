<?php
namespace App\Providers;

use App\Service\SessionAccount;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $account = SessionAccount::GetSession();
            $view->with('account', $account);
        });

        $roles = Role::all();
        $permissions = Permission::all();

        View::composer('role-permission.roles.list', function ($view) use ($roles) {
            $view->with('roles', $roles);
        });

        View::composer('role-permission.roles.create', function ($view) use ($roles, $permissions) {
            $view->with('roles', $roles);
            $view->with('permissions', $permissions);
        });

        View::composer('role-permission.permissions.list', function ($view) use ($roles, $permissions) {
            $view->with('permissions', $permissions);
            $view->with('roles', $roles);
        });
    }
}
