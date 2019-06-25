<?php 

namespace App\Modules\Admin\Services;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Modules\Admin\Services\Upload;

use Storage;

class Galeria
{


	public $collection = [];

	// ...

	public $id; // id produto salvo

	
	public $data = []; // dados filtrados

	
	public $delivery = []; // collection id

	
	public $policys = []; // collection id

	
	public $small = [];


	public function get( Array $collection ) 
	{

		$this->collection = $collection;

		return $this;

	}

	public function get_id( $id )
	{

		$this->id = $id;

		return $this;

	}

	public function product() 
	{
		
		$product = new \App\Models\Produtos;

		if( count($this->data) != 0 ) {
			$product::CreateOrUpdateProduct( $this->data, $this->id );	
		}

		if( empty($this->id) ) {
			$this->id = $product::SetId();
		}

		return $this;
	}

	public function transport() 
	{

		$upload = new Upload;
		
		if( count($this->small) != 0 ) {

			$upload->transport_file( array(
				'file' => $this->small[0]['thumb'],
				'to' => '/uploads/repositorio/'. $this->id .'/thumb_small'
			) );

        }

        return $this;

	}

	public function delivery() 
	{
		
		$delivery = \App\Models\RelServicoEntrega::FindForIdProduct($this->id);
		
		if(count($delivery) == 0) {
			\App\Models\RelServicoEntrega::CreateRels($this->delivery, $this->id);
		}

		elseif(count($this->delivery) == 1){

    		\App\Models\RelServicoEntrega::DeleteForIdProduct($this->id);
    		\App\Models\RelServicoEntrega::CreateRels($this->delivery, $this->id);
    		\App\Models\Produtos::UpdateStatusInstituicao($this->id);

    	}

    	elseif( array_key_exists('instituicao_id', $this->data) ){
    		\App\Models\RelServicoEntrega::DeleteForIdProduct($this->id);
    	}

		return $this;

	}

	public function policys() 
	{

		$policys  = \App\Models\RelPoliticaProdutos::FindForIdProduct($this->id);

		if( count($policys) == 0 ) {
			\App\Models\RelPoliticaProdutos::CreateRels($this->policys, $this->id);
		}

		elseif( json_encode($policys) != json_encode($this->policys) ) {
			
    		\App\Models\RelPoliticaProdutos::DeleteForIdProduct($this->id);
    		\App\Models\RelPoliticaProdutos::CreateRels( $this->policys, $this->id );

    	}

		return $this;

	}

	public function filter()
	{
		
		foreach( $this->collection as $i => $item ) 
		{

			if( is_array($item) && count($item) != 0 ) {
				$this->data[$i] = $item;
			}

			elseif( !empty($item) ) {
				$this->data[$i] = $item;
			}

			elseif(is_int($item)) {
				$this->data[$i] = $item;
			}

		}

		foreach( array('delivery', 'policys', 'small') as $key ) {
			if( array_key_exists($key, $this->data) ) {
				$this->{$key} = array_pull($this->data, $key);
			}
		}

		if( count($this->small) != 0 ) {
			$this->data['thumb_small'] = $this->small[0]['thumb'];
		}
		
		return $this;

	}

	public function create_new_directory() 
	{
		
        $dir = '/uploads/repositorio/' . $this->id;
        
        if( !Storage::disk('local')->exists($dir) ) {
            Storage::makeDirectory($dir);
        }

	}


	/*
		Ação utilizada apenas quando for 
		ativado metodo "update"
	 */

	public function validate_new_data() 
	{

		$products = \App\Models\Produtos::find($this->id)->toArray();
		
		// removendo item da lista
		$products = array_except($products, ['created_at', 'updated_at']);
		$this->data = array_except($this->data, ['id']);

		if( array_key_exists('regras', $this->data) ) {
			$this->data['regras'] = json_encode($this->data['regras']);
		}				
		
		if( $products['thumb_small'] == $this->small[0]['thumb'] ) {
			$this->small = [];
		}

		foreach( array_keys($this->data) as $key ) {
			if( $this->data[$key] == $products[$key] ) {
				$this->data = array_except($this->data, [$key]);
			}
		}
	
		return $this;

	}

	public function format_money() 
	{
		
		// valor da foto, format
		if( array_key_exists('foto_unit_val', $this->data) ) {

			extract($this->data);

			$this->data['foto_unit_val'] = $this->decimal( $foto_unit_val );	

		}
		
		// regras format...
		if( array_key_exists('regras', $this->data) ) {

			extract($this->data);
			
			if(!is_array($regras)) {
				$regras = json_decode($regras, true);
			} 
			
			foreach($regras as $i => $item){
                $regras[$i]['preco'] = $this->decimal( $item['preco'] );
            }

			$this->data['regras'] = json_encode($regras);

		}

		return $this;

	}

	public function decimal( $valor ) 
    {
        return str_replace(',', '.', str_replace('.', '', $valor));
    }

 
}