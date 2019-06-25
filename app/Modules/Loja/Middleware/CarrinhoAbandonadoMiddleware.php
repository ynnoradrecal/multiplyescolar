<?php
namespace App\Modules\Loja\Middleware;

use Closure;
use Carbon\Carbon;
use DB;
use Auth;

class CarrinhoAbandonadoMiddleware
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

		header('Access-Control-Allow-Origin: *');

        $headers = [
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, X-Auth-Token, Origin, Authorization'
        ];



		// recupera o carrinho abandonado
		if( Auth::guard("cliente")->check() ){			

			$session_id = $request->session()->get('session_id');

			$client = Auth::guard("cliente")->user();
			
			$cart = DB::table('carrinho_abandonado')
			->where([
				['cliente_id', '=', $client->id ],
				['status', '=', 1]
			])->orderBy('id', 'desc')->first();	

			$count = DB::table('carrinho_abandonado')
			->where([
				['cliente_id', '=', $client->id ],
				['session_id', '!=', $session_id],
				['status', '=', 1]
			])->count();	
			
			$request->session()->put('ccart', $count);

			if(count($cart)){

				$request->session()->put('last_session_id', $cart->session_id);

				if( $cart->session !== null && $session_id != $cart->session_id ){				
					// $request->session()->put('cart', json_decode($cart->session, false));
					$request->session()->put('utils', json_decode($cart->utils, true));
					$request->session()->put('has_cart', true);
					// dd($request->session());
				}

				if( $cart->session === null ){
					$request->session()->put('has_cart', false);
				}
			}else{
				$request->session()->put('has_cart', false);
			}
			
			//dd($request->session());

		}

		return $next($request);
	}

}