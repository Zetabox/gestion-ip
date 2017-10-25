<?php namespace App\Http\Middleware;

use Closure;
use Entrust;

class CheckRole {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!Entrust::hasRole('SuperAdmin')) {
        return redirect('/auth/logout');
    	}
		return $next($request);
	}

}
