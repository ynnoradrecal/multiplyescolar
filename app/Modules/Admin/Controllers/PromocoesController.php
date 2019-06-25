<?php 

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Modules\Admin\Controllers\Controller;

use App\Modules\Admin\Services\CustomHelpers;
use App\Modules\Admin\Requests\CupomRequest;

use Auth;

class PromocoesController extends Controller
{
	
	protected $view = "Admin::sections.promocoes";

	protected $req;

    protected $validate;

    public function __construct(Request $request) 
    {
        $this->req = $request;
    }


    public function init()
    {

        if( $this->req->input( "methods" ) ) {
            return call_user_func_array(array($this, $this->req->input("methods")), array());
        }else{

            $auth = Auth::guard('admin_user')->user();

            $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);

            return view( $this->view, [
                'login' => 1,
                'user'  => $auth
            ] );

        }

    }

    public function store_data()
    {   

        $vdate = new CupomRequest( $this->req );

        if( $vdate->is_not_success() )   
            return $vdate->is_not_success();

    	\App\Modules\Admin\Services\Cupom::StoreData( $this->req );
        return \App\Modules\Admin\Response\CupomResponse::StoreIsSuccess( $this->req );

    }

    public function up_data() 
    {

        $id = $this->req->input('post.id');

        \App\Modules\Admin\Services\Cupom::UpData( $this->req,  $id );
        return \App\Modules\Admin\Response\CupomResponse::UpIsSuccess( $this->req );

    }

    public function destroy_data()
    {

        $id = $this->req->input('id');

        \App\Modules\Admin\Services\Cupom::DestroyData( $id );
        return \App\Modules\Admin\Response\CupomResponse::DestroyIsSuccess( $this->req );

    }

    public function get_cupons()
    {

    	$collection = \App\Modules\Admin\Services\Cupom::FindAll();
    	
    	if( count($collection) != 0 ) {
    		return \App\Modules\Admin\Response\CupomResponse::ShowData( $collection );
    	}

    	else{
    		return response()->json(array(
    			'message' => 'Error....'
    		), 422);
    	}

    }

    public function get_cupom_where() 
    {
        
        $collection = \App\Modules\Admin\Services\Cupom::FindWhere( 'status', 1 );

        if( count($collection) != 0 ) {
            return \App\Modules\Admin\Response\CupomResponse::ShowData( $collection );
        }

    }

}