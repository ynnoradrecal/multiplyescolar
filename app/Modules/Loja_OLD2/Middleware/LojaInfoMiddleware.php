<?php
namespace App\Modules\Loja\Middleware;

use Closure;
use Carbon\Carbon;
use DB;

class LojaInfoMiddleware
{

	/**
	* Handle an incoming request.
	*
	* @param  \Illuminate\Http\Request $request
	* @param  \Closure $next
	* @return mixed
	*/

	public function handle($request, Closure $next, $guard = null)
	{

		if($request->session()->get('lojaInfo') === null){
			$lojaInfo = DB::table('admin_modulos')
						->where([
							['tipo', '=', 'loja'],
							['status', '=', 1]
						])
						->get();

			for($i = 0; $i < count($lojaInfo); $i++){
				$info[$lojaInfo[$i]->slug] = DB::table('admin_modulo_'. $lojaInfo[$i]->slug )->where('status', '=', 1)->first();
			}

			$request->session()->put('lojaInfo', $info );
		}

		return $next($request);

	}

}