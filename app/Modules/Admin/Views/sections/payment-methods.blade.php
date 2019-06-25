@extends('Admin::master')
@section('content')
	<paymentmethods ref="payment" data="{{ $data }}" url="{{ url('') }}" host="{{ url('') }}/admin/payment-methods"></paymentmethods>
@endsection
