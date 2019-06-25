<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Models\Visita;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class VisitasController extends Controller
{
    
	public function init()
	{
		// Carbon version
		$data = Visita::all();

		return view('Admin::sections.visitas',compact("data"));
	
	}


	public function periodo(Request $request)
	{

		 $this->validate($request, [
			'inicial' => 'required|date',
			'final' => 'required|date',
		]);

		$inicial = $request->input("inicial");
		$final = $request->input("final");
				
		
		$data = Visita::whereBetween('created_at', [
				$inicial, 
				$final
			])->get();


		return $data;
	
	}

	
}