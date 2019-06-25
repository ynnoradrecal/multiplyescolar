<?php 

namespace App\Modules\Admin\Services;

use Illuminate\Http\Request;

use Storage;
use Image;

class Upload 
{


	public function move( $file ) 
    {

        $this->cleaner(array('local'=>'tmp'));

        $path = '/uploads/repositorio/tmp';

        $tmp = $file->getRealPath();
        $name = md5(uniqid(rand(), true)) .".". $file->getClientOriginalExtension();

        $img = Image::make($tmp);

        $img->fit(128, 128, function ($constraint) {
            $constraint->upsize();
        });

        if( !Storage::disk('local')->exists( $path .'/'. $name ) ) {
            $img->save(public_path() . $path .'/'. $name);
        }

        return array(
            'local' => last(explode('/', $path)),
            'path' => $path,
            'thumb' => $name
        );

    }


	/*
			
		transport de umarquivo

		array(
			'to' => '', // destino
			'file' => '' // arquivo
		)

	 */

	public function transport_file( Array $collection ) {

        $tmp = '/uploads/repositorio/tmp'; // temporario
        
        extract($collection);

        if( !Storage::disk('local')->exists( $to ) ) {
        	Storage::makeDirectory($to);
        }

        foreach( Storage::allFiles($tmp) as $files ) {
        	Storage::move($files, $to .'/'. $file);
        }

    }

    public function move_lot() {

    }

    public function transport_lot_file() {

    }

    /*
			
		transport de umarquivo

		array(
			'local' => '', // destino
		)

	 */

    public function cleaner( Array $collection ) {

    	extract($collection);

        $tmp = '/uploads/repositorio/'. $local;

        foreach( Storage::allFiles($tmp) as $file ) {

            if( Storage::disk('local')->exists( $file ) ) {
                Storage::delete($file);
            }

        }

    }


}