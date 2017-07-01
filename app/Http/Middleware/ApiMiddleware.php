<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Response;
class ApiMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// allow origin
		// header('Access-Control-Allow-Origin: *');
		// add any additional headers you need to support here
		// header('Access-Control-Allow-Headers: Origin, Content-Type, access_token');

		// if ($request->header('_token') != md5(env('API_TOKEN')))
		// {
		// 	abort(403, 'Unauthorized action.');
		// }
		$request->route()->forgetParameter('version');
		// if($request->getMethod() == "OPTIONS") {
		// 	return Response::make('OK', 200, [
		// 		'Access-Control-Allow-Origin' => '*',
		// 		'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, access_token',
		// 		'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE'
		// 		]);
		// }
		// dd($request->json()->all());
		$request->merge($request->json()->all());
		$content = $next($request);
  		return $content
  			->header('Access-Control-Allow-Origin' , '*')
			->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
			->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin, access_token');
	}

}
