<?php namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);

		//
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function($router)
		{
			require app_path('Http/routes.php');
			
			// Dynamically include all files in the routes directory
			$routerDir = app_path('Http/Routes');
			foreach (new \DirectoryIterator($routerDir) as $file)
			{
			    if (!$file->isDot() 
			    	&& !$file->isDir() 
			    	&& preg_match('/.*\.route\.php$/', $file->getFilename()))
			    {
			        require_once $routerDir.DIRECTORY_SEPARATOR.$file->getFilename();
			    }
			}
		});
	}

}
