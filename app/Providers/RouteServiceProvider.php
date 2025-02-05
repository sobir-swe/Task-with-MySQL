<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * @var string
	 */
	public const HOME = '/dashboard';

	public function boot(): void
	{
		$this->configureMiddleware();

		$this->configureRateLimiting();

		$this->routes(function () {
			$this->mapApiRoutes();
			$this->mapWebRoutes();
		});
	}

	protected function configureMiddleware(): void
	{
		$this->middlewareAliases = [
			'auth' => \App\Http\Middleware\Authenticate::class,
			'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
			'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
			'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
			'can' => \Illuminate\Auth\Middleware\Authorize::class,
			'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
			'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
			'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
			'signed' => \App\Http\Middleware\ValidateSignature::class,
			'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
			'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

			// O'zingizning custom middleware'laringizni bu yerda qo'shing
			'admin' => \App\Http\Middleware\AdminMiddleware::class,
		];
	}

	protected function configureRateLimiting(): void
	{
		RateLimiter::for('api', function (Request $request) {
			return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
		});
	}

	protected function mapApiRoutes(): void
	{
		Route::middleware('api')
			->prefix('api')
			->group(base_path('routes/api.php'));
	}

	protected function mapWebRoutes(): void
	{
		Route::middleware('web')
			->group(base_path('routes/web.php'));
	}
}
