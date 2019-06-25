<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CatalogoController extends Controller
{
  
	protected $view = "";

	public function __construct() 
	{



	}

	public function fotos()
	{
		return view("Admin::sections.fotos", array("title"=>"Fotos",
		"login"=>1));
	}

	public function repositorio()
	{
		return view("Admin::sections.repositorio", array("title"=>"Repositório",
		"login"=>1));
	}

	public function politica()
	{
		return view("Admin::sections.politica",
		[
			"login" => 1,
			"data" => response()->json(["name"=>"Json Bourne"])
		]);
	}

}
