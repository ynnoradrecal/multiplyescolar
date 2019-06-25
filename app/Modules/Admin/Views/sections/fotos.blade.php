@extends('Admin::master')
@section('content')
	<fotos ref="fotos" url="{{ url('') }}" host="{{ url('') }}/admin/fotos"></fotos>
@endsection