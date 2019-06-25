<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SistemaController extends Controller
{
	public function usuarios()
	{

		$data = [
			"title"=>"Usuários",
			"login"=>1
		];		

		return view("Admin::sections.usuarios", $data);
	}
}
