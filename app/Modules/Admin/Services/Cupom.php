<?php 

namespace App\Modules\Admin\Services;

use Illuminate\Http\Request;

class Cupom 
{

	protected static $fill = ['name', 'code', 'date_validate', 'limit_for_use', 'type', 'value', 'status', 'descricao'];

	public function __construct() 
	{

		// ...

	}

	public static function FindAll()
	{
		return \App\Models\DiscountCupon::all();
	}

	public static function FindOne( $id )
	{

		return \App\Models\DiscountCupon::find( $id );
		
	}

	static function FindWhere( $label, $value ) 
	{

		return \App\Models\DiscountCupon::where($label, $value)
               ->orderBy('id', 'asc')->get();

	}

	public static function StoreData( $req )  
	{

		foreach( self::$fill as $item ) {

			if(!empty( $req->input('post.'. $item) )) {

				if($item == 'code') {
					$collection[$item] = strtoupper($req->input('post.'. $item));
				}

				elseif($item == 'date_validate') {
					$collection[$item] = self::FormatDate($req->input('post.'. $item));
				}

				else{
					$collection[$item] = $req->input('post.'. $item);
				}
			}

		}

		\App\Models\DiscountCupon::create( $collection );

	}

	public static function UpData( $req, $id )  {


		foreach( self::$fill as $item ) {
			if( !empty( $req->input('post.'. $item) )  ) {
				if($item == 'code') {
					$colletion[$item] = strtoupper($req->input('post.'. $item));
				}

				elseif($item == 'date_validate') {
					$colletion[$item] = self::FormatDate($req->input('post.'. $item));
				}

				else{
					$colletion[$item] = $req->input('post.'. $item);
				}
			}
		}

		\App\Models\DiscountCupon::where('id', $id)
			->update($colletion);

	}

	public static function DestroyData( $id )  
	{

		\App\Models\DiscountCupon::destroy($id);

	}

	static function FormatDate( $str ) 
	{

		$date = implode('-', array_reverse(explode('/', $str)));
		$date = date('Y-m-d h:m:i', strtotime($date));

		return $date;

	}

}