<?php
namespace App\Modules\Loja\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Auth;
use Socialite;


class SocialAuthController extends Controller{

	public function loginWithFacebook()
	{
		return Socialite::driver("facebook")->redirect();
	}

	public function returnFromFacebook(Request $request)
	{

		if( $request->input('error_code') !== null ){
			return redirect('login-cadastro')->with([
					'facebook'=>'Falha ao tentar se comunicar com o facebook, por favor tente mais tarde!'
				]); 
		}		

		$socialUser = Socialite::driver("facebook")->stateless()->user();
		$email = $socialUser->getEmail();

		if( Auth::guard('cliente')->check() ){
			$user = Auth::guard('cliente')->user();
			$user->email = $email;
			$user->save();

			if( $request->session()->get('session_id') === null )
			$request->session()->put('session_id', date('Ymd.His'));
			
			return redirect()->intended('eventos'); 
		}

		$user = Cliente::where('email', $email)->first();

		if(count($user) > 0){
			
			$user->name = $socialUser->user['first_name'];
			$user->last_name = $socialUser->user['last_name'];
			$user->avatar = $socialUser->avatar;
			$user->update();

			Auth::guard('cliente')->login($user);

		}else{

			if( $socialUser->user['gender'] == 'male'){
				$sexo = 'M';
			}else{
				$sexo = 'F';
			}

			$user = Cliente::create([
				'name' 			=> $socialUser->user['first_name'],
				'last_name'		=> $socialUser->user['last_name'],
				'email'			=> $socialUser->user['email'],
				'sexo' 			=> $sexo,
				'password'		=> bcrypt($socialUser->id),
				'avatar'		=> $socialUser->avatar,
				'termos' 		=> 'Declaro que li e aceito todos os termos de compra'
			]);

			Auth::guard('cliente')->login($user);
		}

		return redirect()->intended('eventos'); 

	}
}