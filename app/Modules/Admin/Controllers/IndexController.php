<?php

namespace App\Modules\Admin\Controllers;

use DB;
use Hash;
use Auth;

use App\Models\AdminUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class IndexController extends Controller
{

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	protected $req;

	protected $guard = 'admin_user';



	public function __construct( Request $req ) 
	{
		$this->req = $req;
		$this->middleware('guest', ['except' => 'logout']);
	}

	/**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data

     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admin_user',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**

     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    protected function create(array $data)
    {
        return AdminUser::create([
            'nome' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

	public function init() 
	{

		$req = $this->req;

		if( $req->input('methods') ) {
			return call_user_func_array(array($this, $req->input("methods")), array());
		}else{
			return view('Admin::sections.index', array("login"=>0));	
		}

	}

	public function __in() 
	{

		$data = $this->req->input('data');
		$check = array('email'=>$data['login'], 'password'=>$data['senha']);

		$this->validate($this->req, array(
			'data.login' => 'required|email',
			'data.senha' => 'required'
		));

		if( Auth::guard('admin_user')->attempt($check) ) {
			
			return array(
				'status' => 1,
				'redirect' => url('') .'/admin/painel'
			);

		}

		return array(
			'status' => 0,
			'alert' => array(
				'title' => 'Falha no Login!',
				'text' => 'Seu e-mail ou senha não foram localizado em nossa base de dados.',
				'type' => 'warning'
			)
		);

	}

	public function __out() 
	{	

		Auth::guard('admin_user')->logout();
		return redirect('/admin');

	}

}
