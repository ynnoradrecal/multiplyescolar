@extends('Admin::master')
@section('content')
	<deliverymethods ref="delivery" data="{{ $data }}" url="{{ url('') }}" host="{{ url('') }}/admin/delivery-methods"></deliverymethods>
@endsection
