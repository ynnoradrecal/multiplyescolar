@extends('Admin::master')

@section('content')
	
	<visitas ref="visitas" data="{{ $data }}" url="{{ url('') }}"></visitas>

@endsection