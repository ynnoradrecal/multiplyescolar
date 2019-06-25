<?php

namespace App\Modules\Loja\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Endereco;
use Validator;
use DB;
use Auth;

class ClientesController extends Controller
{

	public function cadForm(){
		return view('Loja::screens.cadastro');
	}

	/*
	// insere mo banco de dados as informações sobre o cliente, 
	// cadastro inicial com poucos dados
	*/
	public function storeClientSoft( Request $request)
	{

		$validator = Validator::make($request->all(), [
			'nome' 		=> 'required|min:2|max:150',
			'sobrenome' => 'required|min:1|max:150',
			'email' 	=> 'required|email|min:3',
			'pass' 		=> 'required',
			'check'		=> 'required'
		]);

		if ($validator->fails()) {
			return	redirect()
						->back()
							->withErrors($validator)
								->withInput()
									->with('form', 'cadastro');
		}		

		$getClient = Cliente::where('email', '=', $request->input('email'))->first();

		if (count($getClient) > 0 ){
			return	redirect()
						->back()
							->withErrors([
								'email' => 'Este email já está cadastrado em nosso sistema.',
								'mensagem' 	=> 'Não foi possível salvar seus dados.'
								])
								->withInput()
									->with('form', 'cadastro');
		}

		
		Cliente::insert([
			'name' 		=>  $request->input('nome'),
			'last_name' =>  $request->input('sobrenome'),
			'email' 	=>  $request->input('email'),
			'password' 	=>  bcrypt($request->input('pass')),
			'termos' 	=>  $request->input('check')
		]);

		return	redirect()->back()->with('cad-success', 'Sucesso!');
	}


	/*
	// lista endereco do respectivo cliente
	*/
	public function listaEndereco($cliente_id)
	{

		$enderecos = Endereco::where('cliente_id', $cliente_id)->get();

		return view('Loja::screens.lista_endereco', compact("enderecos"));
	}


	/*
	// mostra formulário de edição de endereço do respectivo cliente
	*/
	public function showEndereco($id)
	{
		$endereco = Endereco::find($id);		

		return view('Loja::loggedin.cad-update-endereco', compact("endereco"));
	}


	// atualiza endereço do respectivo cliente
	public function atualizaEndereco( $id, Request $request)
	{
		$validate = $this->validate($request, [
			'logradouro' => 'required|min:4|max:150',
			'numero' => 'required',
			'cep' => 'required|min:8',
			'bairro' => 'required',
			'cidade' => 'required',
			'estado' => 'required'
		]);

		$endereco = Endereco::find($request->input("endereco_id"));

		$endereco->logradouro = $request->input("logradouro");
		$endereco->numero = $request->input("numero");
		$endereco->complemento = $request->input("complemento");
		$endereco->cep = $request->input("cep");
		$endereco->bairro = $request->input("bairro");
		$endereco->cidade = $request->input("cidade");
		$endereco->estado = $request->input("estado");
		$endereco->update();

		return redirect( 'minha-conta/'. $request->input("user_id") .'/enderecos');
	}


	// lista pedidos
	public function listPedidos( $cliente_id )
	{
		$pedidos = DB::table("pedidos")->where([
			['pedidos.cliente_id', '=', $cliente_id]
		])->get();
		
		return view( 'Loja::loggedin.lista-pedidos', compact("pedidos"));
	}

	/// mostra pedido por cliente e id do pedido_id
	public function showPedido( $cliente_id, $pedido_id, $ref )
	{
		$pedido = DB::table('clientes')
			->where('clientes.id', '=', $cliente_id )
			->join('pedidos', 'pedidos.cliente_id', '=', 'clientes.id')
			->where('pedidos.id', '=', $pedido_id)
			->join('itens_pedidos as itens', 'itens.pedido_id', '=', 'pedidos.id')
			->join('enderecos as end', 'end.id', '=', 'pedidos.endereco_id')
			->get();

		// caso exista algum dado errado
		if( count($pedido) == 0){
			return redirect()
					->back()
						->with(['referencia' =>  $ref]);
		}

		for($i =0; $i < count($pedido); $i++){
			if($pedido[$i]->titulo == 'Foto'){
				$fotos[] = DB::table('fotos_produto')->where('id',$pedido[$i]->item_id)->first();
			}
		}

		return view( 'Loja::loggedin.detalhe-pedido', compact('pedido', 'fotos'));

	}


	// mostra rela de área do cliente
	public function showDadosCliente()
	{
		return view("Loja::loggedin.atualiza-dados-cliente");
	}


	// recebe parametros Post para atualização de dados do cliente
	public function updateDadosCliente( Request $request ){

		$validate = $this->validate($request, [
			'name' 				=> 'required|min:2',
			'last_name' 		=> 'required|min:2',
			'email'				=> 'required|email|min:3',
			'telefone'			=> 'required|min:10',
			'celular' 			=> 'required|min:10',
			'data_nascimento' 	=> 'required',
			'sexo' 				=> 'required|min:1',
			'cpf' 				=> 'required|min:14'
		]);

		if( $request->input('password') != '' && $request->input('password') == $request->input('confirm-password')){
			
			$clienteData = array_except($request->all(),['confirm-password', '_token','id']);
			// adiciona encript a senha
			$clienteData['password']  = bcrypt($request->input('password'));

		}else{
			// retira password(cliente não solicitou alteracao de senha)
			$clienteData = array_except($request->all(),['password','confirm-password','_token','id']);
		}

		Cliente::where('id', $request->input('id'))->update( $clienteData );

		return view("Loja::loggedin.atualiza-dados-cliente",['success' => 'Dados atualizados com sucesso']);
	}


	// altera endereço principal (function invocada por ajax)
	public function alteraEnderecoPrincipal($user_id, $endereco_id)
	{

		$enderecos = DB::table('rel_conts_ends')
			->where([
				['rel_conts_ends.id_conta', '=', $user_id],
				['rel_conts_ends.tipo_de_conta', '=', 'cliente']
			])->get();
			
		for($i = 0; $i < count($enderecos); $i++){
			
			$endereco = Endereco::find( $enderecos[$i]->id_endereco );
			
			if( $enderecos[$i]->id_endereco == $endereco_id ){
				$endereco->entrega = 1;
			}else{
				$endereco->entrega = 0;
			}
			$endereco->update();
		}

		return true;
		
	}

	// mostra lista de endereços cadastrados
	public function listEnderecos($id_usuario){

		$enderecos = DB::table('rel_conts_ends')
					->where([
						['rel_conts_ends.id_conta', '=', $id_usuario],
						['rel_conts_ends.tipo_de_conta', '=', 'cliente']
					])
						->join('enderecos as end', 'end.id', '=','rel_conts_ends.id_endereco')
							->select('end.*')
								->get();

		$cliente = Cliente::where('id', $id_usuario )->get(['name','last_name']);

		$cliente = $cliente[0];
		
		return view("Loja::loggedin.lista-enderecos", compact('enderecos', 'cliente'));
	}


	//  mostra view de cadastro de endereço
	public function showCadastroEndereco()
	{
		// formulário de cadastro e atualização dos endereços
		return view("Loja::loggedin.cad-update-endereco");
	}

	public function cadastraEndereco(Request $request)
	{

		$validate = $this->validate($request, [
			'logradouro' => 'required|min:2',
			'cep'	=> 'required|min:8',
			'numero' => 'required|min:1',
			'bairro' => 'required|min:2',
			'estado' => 'required|min:2',
			'cidade' 	=> 'required|min:2'
		]);

		$complemento = '';

		if( null !== $request->input('complemento') ){
			$complemento = $request->input('complemento');
		}

		$endereco = Endereco::create([
			'logradouro'=>  $request->input('logradouro'),
			'cep' 		=>  $request->input('cep'),
			'numero' 	=>  $request->input('numero'),
			'bairro' 	=>  $request->input('bairro'),
			'estado' 	=>  $request->input('estado'),
			'cidade' 	=>  $request->input('cidade')
		]);

		$relacionamento = [
			'id_conta' 		=> $request->input('user_id'),
			'tipo_de_conta' => 'cliente',
			'id_endereco' 	=> $endereco->id
		];

		DB::table('rel_conts_ends')->insert($relacionamento);

		return redirect('minha-conta/'. $request->input('user_id') .'/enderecos');

	}


	// mostra formulário de atendimento
	public function showAtendimento()
	{
		// tanto o cadastro como a atualização dos
		return view("Loja::loggedin.atendimento");
	}


	//  salva formulário de atendimento
	public function saveAtendimento(Request $request)
	{
		dd($request);
	}

}