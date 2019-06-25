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

		// email de destino
		$to = 'neferson.oliveira@wa5.com.br';

		if($requests->input("form") == 'contato'){

			// cria a validação
			$validator = Validator::make($requests->all(), [
				'nome' 		=> 'required|min:2|max:150',
				'email' 	=> 'required|email|min:3',
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
			if(!$email->formContato( $requests, $to )){
				return redirect()
							->back()
								->withInput()
									->withErrors(['erro' => 'Por favor veirifique seus dados e tente novamente.']);
			}else{
				return redirect()
							->back()
								->with(['success' => 'Agradecemos o contato.']);	
			}


		}else if( $requests->input("form") == 'support' ){

			//dd($requests);

			// cria a validação
			$validator = Validator::make($requests->all(), [
				'nome' 		=> 'required|min:2|max:150',
				'email' 	=> 'required|email|min:3',
				'assunto' 	=> 'required|min:8|max:150',
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
}
