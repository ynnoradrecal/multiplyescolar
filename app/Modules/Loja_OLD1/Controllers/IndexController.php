<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Loja\Helpers\EmailHelper;
use Mail;
use Session;
use Config;
use Validator;
use DB;

class IndexController extends Controller
{
	//

	public function index(){
		//echo '<h1>Teste</h1>';
		return view("Loja::paginas.home");
	}

	public function emailPedido($id)
	{
		$pedidos = $this->getOrderDataTo($id);
		return view("Loja::emails.confirmacao-compra", compact('pedidos'));
	}

	public function loginCadastro(){
		return view("Loja::paginas.login-cadastro");
	}

	public function contato(){
		return view("Loja::paginas.contato");
	}

	public function addToCart(Request $requests){
		dd($requests->all());
		// return view("Loja::paginas.contato");
	}

	public function sendEmail(Request $requests)
	{

		// recupera dados para configuração
		$config = DB::table('admin_modulo_contato')->where("status", '=', 1)->first();

		// sobrescreve configuração padrão
		if( count($config) > 0){
			Config::set('mail.username', $config->email_autenticacao);
			Config::set('mail.password', $config->senha);
			Config::set('mail.host', $config->smtp);
			Config::set('mail.from', $config->remetente);
			Config::set('mail.port', $config->porta);
			Config::set('mail.encryption', $config->encriptacao);

			$to = $config->destino;
		}

		// email developer
		$to = 'neferson.oliveira@wa5.com.br';

		// email production
		// $to = 'atendimento@multiply.art.br';

		if($requests->input("form") == 'contato'){			

			// cria a validação
			$this->validate($requests, [
				'nome' 		=> 'required|min:2|max:150',
				'email' 	=> 'required|email|min:3',
				'mensagem' 	=> 'required'
			]);

			// checa se existe erros e redireciona de volta
			// if ($validator->fails()) {
			// 	dd($validator);
			// }
			
			// inicia classe que enviará o email
			$email = new EmailHelper();		

			// caso retorne false, existe algum erro 
			if(!$email->formContato( $requests, $to )){
				return json_encode(array('erro' => 'Por favor veirifique seus dados e tente novamente.'));
			}else{
				return json_encode(array('success' => 'Agradecemos o contato.'));	
			}


		}else if( $requests->input("form") == 'support' ){
			
		
			// cria a validação
			$validator = Validator::make($requests->all(), [
				'name' 		=> 'required',
				'email' 	=> 'required',
				'assunto' 	=> 'required',
				'mensagem' 	=> 'required'
			]);			
			
			// checa se existe erros e redireciona de volta
			if ($validator->fails()) {
				return	redirect()
							->back()
								->withErrors($validator)
									->withInput();
			}			
			
			// inicia classe que enviará o email
			$email = new EmailHelper();

			// caso retorne false, existe algum erro 
			if(!$email->formSupport( $requests, $to )){

				return redirect()
							->back()
								->withInput()
									->withErrors(['erro' => 'Por favor veirifique seus dados e tente novamente.']);
			}else{

				return redirect()
							->back()
								->with(['success' => 'Nossa equipe retornará o contato em breve.']);	
			}

		}

		
	}

	public function getOrderDataTo($id)
	{
		$pedido = DB::table('pedidos as p')
					->where('p.id', $id)
					->leftJoin('itens_pedidos as ip', 'ip.pedido_id', '=', 'p.id')
					->leftJoin('enderecos as end', 'end.id', '=', 'p.endereco_id')
					->leftJoin('produtos as prod', 'prod.id', '=', 'ip.produto_id')
					->leftJoin('events', 'events.id', '=', 'prod.event_id')
					->select('prod.nome as prod_nome', 'events.name as event_name', 'end.*', 'ip.*', 'p.*')
					// ->select('ip.*')
					->get();
		//  dd($pedido);
		return $pedido;
	}
}
