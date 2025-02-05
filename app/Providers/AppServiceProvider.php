<?php
namespace App\Providers;

use App\Models\Account;
use App\Service\SessionAccount;
use Illuminate\Database\Eloquent\Relations\Relation;
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
	    Relation::enforceMorphMap([
		    'account' => 'App\Models\Account',
	    ]);

        View::composer('*', function ($view) {
            $client = SessionAccount::GetSession();
            $view->with('client', $client);
			$view->with('currentAccount', $client);
        });

        $roles = Role::all();
        $permissions = Permission::all();

        View::composer('roles.list', function ($view) use ($roles) {
            $view->with('roles', $roles);
        });

        View::composer('roles.create', function ($view) use ($roles, $permissions) {
            $view->with('roles', $roles);
            $view->with('permissions', $permissions);
        });

        View::composer('permissions.list', function ($view) use ($roles, $permissions) {
            $view->with('permissions', $permissions);
            $view->with('roles', $roles);
        });
    }
}
