<?php

namespace App\Modules\Admin\Controllers;

use DB;
use Auth;

use Illuminate\Http\Request;

use App\Models\Configuracao;
use App\Models\Pagseguro;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Services\CustomHelpers;

class PaymentMethodsController extends Controller
{

	protected $view = 'Admin::sections.payment-methods';

	public function init()
	{
		$tipo =  'pagamento';		

		$data = Configuracao::where('tipo','=', $tipo)->get();

		$auth = Auth::guard('admin_user')->user();
        $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);

        $login = 1;
        $user = $auth;

        return view( $this->view, compact('data', 'login', 'user'));
	}


	public function create( Request $request ) 
	{
		$payment = MetodosPagamento::create($request->all());
		if( $payment ){
			return response()->json(["id"=>$payment->id]);
		}
	}


	public function update(Request $request)
	{
		// Edita somente as informações do módulo
		$updateModulo = Configuracao::find( $request->input('modulo_id') );
		$updateModulo->nome = $request->input('nome');
		$updateModulo->status = $request->input('status');
		$updateModulo->save();

		// Edita somente as informações do metodo de pagemento
		if($request->input('slug') == 'pagseguro'){
			$updateMetodo = Pagseguro::find(1);
			$updateMetodo->email = $request->input('email');
			$updateMetodo->url_redirect = $request->input('url_redirect');
			$updateMetodo->token = $request->input('token');
		}

		$updateMetodo->save();

		$getAllPaymentMethods = Configuracao::all()->where( 'tipo', '=' , 'pagamento' );

		return $getAllPaymentMethods;
	}


	public function delete( Request $request ) 
	{
		$delete = MetodosPagamento::find($request->input('id'));
		$delete->delete();

		return $this->getAllMethods();
	}


	protected function getAllMethods()
	{
		return MetodosPagamento::get();
	}


	public function getPayment($payment)
	{
		return DB::table('admin_modulo_'.$payment)->get();
	}

}
