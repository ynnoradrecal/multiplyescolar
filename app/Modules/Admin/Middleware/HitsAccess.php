<?php
namespace App\Modules\Admin\Middleware;

use Closure;
use Carbon\Carbon;
use DB;
use App\Models\Visita;
use App\Modules\Admin\Services\UserAgent;

class HitsAccess
{
	/**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
	public function handle($request, Closure $next, $guard = null)
	{
		// Test to see if the requesters have an ip address.	
		$server = $request->server();

		// filtra o nome do browser e S.O  do cliente
		$userAgent =  new UserAgent( $server['HTTP_USER_AGENT'] );
		$userAgentData = $userAgent->getBrowser();

		// cria datas para incrementar o contador
		$de = Carbon::now()->setTime(0,0,0)->format('Y-m-d H:i:s');
		$ate = Carbon::now()->setTime(23,59,59)->format('Y-m-d H:i:s');

		// Seleciona visita(caso exista)
		$select = Visita::where([
			['ip','=', $server['REMOTE_ADDR']],
			['pagina','=', $server['REQUEST_URI']]
		])->whereBetween('created_at',[$de, $ate ])->get();

		// caso encontre acesso, atualiza contagem
		if( count($select) > 0 ){

			for($i = 0; $i < count($select); $i++){
				$update = Visita::find( $select[$i]->id ); // invoca classe para atualização
				$update->contador = ($select[$i]->contador + 1); // incrementa contagem na tabela de visitas
				$update->save(); // atualiza contagem na tabela de visitas
			}

		}else{ // caso não encontre acesso, cria novo acesso

			$visita = Visita::create([
				'ip' => $server['REMOTE_ADDR'], 
				'dispositivo' => $server['HTTP_USER_AGENT'], 
				'navegador' => $userAgentData['name'],
				'sistema' => $userAgentData['platform'],
				'pagina' => $server['REQUEST_URI'],
				'contador' => 1 
			]);
		}

		return $next($request);

	}
}