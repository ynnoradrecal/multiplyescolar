<?php
namespace App\Modules\Admin\Controllers\Auth;

use App\Models\User;
use App\Modules\Admin\Requests;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Response;

class AuthController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = 'admin';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:6|confirmed',
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
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}

	public function authenticate(Request $request)
	{
		
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'senha' => 'required',
		]);

		if ($validator->fails()) {
			return redirect()
					->back()
					->withErrors($validator)
					->withInput();
		}

		$credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];

		if( Auth::guard()->attempt( $credentials ) ) {			
			
			return redirect()->route("admin.accounts"); 
		
		} else {

			return 	redirect()
					->back()
					->withInput()
					->withErrors( ['message' => 'O campo email e/ou o campo senha estão incorretos.'] );
		}
	}

	protected function logout()
	{
		Auth::logout();
		return redirect()->route('admin.login');
	}
}
