<?php 

namespace App\Modules\Admin\Services;

use Storage;

use Illuminate\Http\Request;

class CustomHelpers 
{
	
	static function __get_before_photo_user( $local, $foto )
	{

		if( !Storage::disk('local')->exists('/uploads/usuarios/'. $local . '/' . $foto ) ) {
			return '/uploads/usuarios/multiply.jpg';
		}

		return '/uploads/usuarios/'. $local . '/' . $foto;

	}

}