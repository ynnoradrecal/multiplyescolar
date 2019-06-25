<?php
namespace App\Modules\Loja\Middleware;

use Closure;
use Carbon\Carbon;
use DB;
use Auth;

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

		// recupera o carrinho abandonado
		// if(Auth::guard("cliente")->check()){

		// 	$session_id = $request->session()->get('session_id');

		// 	$client = Auth::guard("cliente")->user();
		// 	$cart = DB::table('carrinho_abandonado')
		// 	->where([
		// 		['cliente_id', '=', $client->id ],
		// 		['status', '=', 1]
		// 	])->first();

		// 	if( $cart->session !== null && $session_id !== $cart->session_id ){
		// 		die("tem carrinho");
		// 	}
		// }

		return $next($request);

	}

}