<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		//--stop globally---
		'App\Http\Middleware\CORS',
		//'App\Http\Middleware\VerifyCsrfToken',
		/**
		 * for OAuth2 authentication
		 */
		// 'LucaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware'
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'App\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
		'csrf' => 'App\Http\Middleware\VerifyCsrfToken',
		/**
		 * for my custom api authentication
		 */
		'api' => 'App\Http\Middleware\ApiMiddleware',
		/**
		 * for OAuth2 authentication
		 */
		// 'oauth' => 'LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware',
		// 'oauth-owner' => 'LucaDegasperi\OAuth2Server\Middleware\OAuthOwnerMiddleware',
		// 'check-authorization-params' => 'LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware',
	];

}
