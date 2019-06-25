<?php
namespace App\Modules\Loja\Controllers;


use App\Models\Cliente;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;

class ClientesLoginController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/loja/teste';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:clientes',
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
        return Cliente::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    // public function clienteLogin()
    // {  
    //     return view('adminLogin');    
    // }


    public function clienteLoginPost( Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];

        if( Auth::guard('cliente')->attempt( $credentials ) ) {
            
            return redirect()->route("area.cliente"); // redireciona o cliente para a área do cliente

        }else{           
            
            return redirect()
                            ->back()
                                ->withErrors(["message" => "O email e/ou senha estão incorretos!"])
                                    ->withInput();
        }
    }

     public function clienteLogout(Request $request){
        Auth::guard('cliente')->logout();
        $request->session()->flush();
        return redirect()->route("loja.index");
    }    

}