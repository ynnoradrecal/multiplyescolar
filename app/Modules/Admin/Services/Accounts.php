<?php 

namespace App\Modules\Admin\Services;

use Illuminate\Http\Request;

class Accounts 
{

	
	protected $field = array(

		"instituicao" => array(
			"nome"       => "required",
        	"telefone"   => "",
        //  "taxa"       => ""
		),

		"alunos" => array(
		),

		"clientes" => array(
		),

		"address" => array(
			"logradouro" => "required",
        	"estado"     => "required",
        	"cidade"     => "required",
        	"cep"        => "required",
        	"bairro"     => "required",
        	"numero"     => "required"
		)

	);


	public function __construct( Array $args ) 
	{	

		extract($args);
		
		if( in_array($action, array("insert", "update")) ) { // insert, update

			extract($tables);

			$rules = array_merge($this->field[$type], $this->field["address"]);
			$el->validate($req, $this->rulesValidate($data, $rules)); // validação

			$this->rel(array(
				"id_account" => $this->{ $action }( $data, $db_account ),
				"id_address" => $this->address( $data, $db_address ),
				"type"       => $type
			), $db_rel);

		}else{ // delete

		}

	}


	public function rulesValidate( $data, $rules )
	{
					
		$diff = array_diff(array_keys($rules), array_keys($data));
		
		foreach( $rules as $i => $value ) {

			if( (empty($data[$i]) && $value == "required") || (in_array($i, $diff) && $value == "required") ) {
				$rules["post.". $i] = $value;
			}

            unset($rules[$i]);

        }
        
        return $rules;

	}


	public function insert( $data, $db ) 
	{
		
		foreach( array("nome", "telefone", "taxa", "descricao") as $i )
			$field[$i] = !empty($data[$i]) ? $data[$i] : "";

        return $db->insertGetId($field);

	}


	public function address( $data, $db ) 
	{

		$fields = array("logradouro","estado","cidade","cep","bairro","numero");

		foreach( $fields as $i )
			$field[$i] = $data[$i];
		
        return $db->insertGetId($field);

	}

	public function rel( Array $args, $db )
	{

		extract( $args );

		$db->insert(array(
			"id_conta" => $id_account,
			"tipo_de_conta" => $type,
			"id_endereco" => $id_address
		));

	}

	static public function response() 
	{

	}

}