<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

use Input;
use Storage;
use Image;
use DB;
use Auth;

use App\Modules\Admin\Requests;
use App\Modules\Admin\Controllers\Controller;
use App\Modules\Admin\Services\CustomHelpers;

class EventsController extends Controller
{

    protected $view = "Admin::sections.events";

    protected $req;

    public function __construct(Request $req) 
    {
        $this->req = $req;
    }

    public function init()
    {
        

        if( !empty($this->req->input('methods')) ) {

            return call_user_func_array(array(
                $this, 
                $this->req->input("methods")
            ), array());

        }else{

            $auth = Auth::guard('admin_user')->user();
            $auth->foto = CustomHelpers::__get_before_photo_user($auth->id, $auth->foto);

            $data = array(
                "login" => 1,
                'user' => $auth
            );

            return view( $this->view, $data );

        }
    }

    public function getAllEvents() 
    {
        return Event::all();
    }

    public function upload() 
    {

        $file = Input::file('file');
        $path = '/uploads/tmp';

        $tmp = $file->getRealPath();
        $name = md5(uniqid(rand(), true)) .".". $file->getClientOriginalExtension();

        $img = Image::make($tmp);

        if( !Storage::disk('local')->exists( $path .'/'. $name ) ) {
            $img->save(public_path() . $path .'/'. $name);
        }

        return array(
            'data' => array(
                'path' => $path,
                'capa' => $name
            )
        );
    }

    public function excluir_image() 
    {

        $image = $this->req->input('image');
        
        foreach( $image as $item ) {

            $file = $item['path'] .'/'. $item['capa'];

            if( Storage::disk('local')->exists($file) ) {
                Storage::delete($file);
            }

            DB::table('events')->where('name', '=', $item['capa'])
                ->delete();

        }

        return array(
            'alert'=>array(
                'title' => 'Sucesso!',
                'text' => 'Imagem removida com sucesso!',
                'type' => 'success'
            )
        );
    }

    public function save() 
    {

        $data = $this->req->input('data');
        $to = '/uploads/capas';

        $data['capa'] = !isset($data['capa']) ?  array() : $data['capa'];

        $rules = array('data.name' => 'required', 'data.parcelas'=>'required', 'data.description' => 'required');
        $rules['data.capa'] = count($data['capa']) == 0 ? 'required' : '';

        $this->validate($this->req, $rules);

        // transporte do arquivo
        foreach( $data['capa'] as $i => $item ) {

            $file = $item['path'] .'/'. $item['capa'];

            if( Storage::disk('local')->exists( $file ) ) {
                Storage::move($file, $to .'/'. $item['capa']);
            }

            $data['capa'][$i] = array(
                'path' => $to,
                'capa' => $item['capa']
            );

        }

        $data['capa'] = json_encode($data['capa']);

        DB::table('events')->insert($data);

        return array(
            'alert' => array(
                'title' => 'Sucesso!',
                'text'  => 'Evento '. $data['name'] .' salvo com sucesso.',
                'type'  => 'success'
            )
        );
    }

    public function put() 
    {

        $data   = $this->req->input('data');
        $events = DB::table('events')->where('id', '=', $data['id'])->get();
        $query  = array();

        $data['capa'] = json_encode($data['capa']);
        
        foreach( $events as $item ) {
            foreach( array_keys(get_object_vars($item)) as $i ) {
                if(in_array($i, array('name', 'parcelas', 'description', 'capa')) && $item->{$i} != $data[$i]) {
                    $query[$i] = $data[$i];
                }
            }
        }

        // capa
        if( !empty($query['capa']) ) {

            $capa = json_decode($query['capa'], true);

            foreach( $capa as $item ) {

                $file = '/uploads/capas/'. $item['capa'];
                Storage::move('/uploads/tmp/'. $item['capa'], substr($file, 1));

            }

            $query['capa'] = str_replace('tmp', 'capas', $query['capa']);

        }
        
        DB::table('events')->where('id', '=', $data['id'])->update($query);

        return array(
            'alert' => array(
                'title' => 'Sucesso!',
                'text' => 'Evento '. $data['name'] .' alterado com sucesso.',
                'type' => 'success'
            )
        );
    }

    public function destroy()
    {

        $data = $this->req->input('data');

        foreach( $data['capa'] as $item ) {

            $file = isset($item['path']) ? $item['path'] .'/'. $item['capa'] : '';

            if( Storage::disk('local')->exists($file) ) {
                Storage::delete($file);
            }

        }

        DB::table('events')->where('id', '=', $data['id'])->delete();

        return array(
            'alert' => array(
                'title' => 'Sucesso!',
                'text' => 'Evento '. $data['name'] .' excluido com sucesso.',
                'type' => 'success'
            )
        );
    }

    

}
