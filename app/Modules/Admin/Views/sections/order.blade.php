@extends('Admin::master')
@section('content')
	<order ref="order" url="{{ url('') }}" api="{{ url('') }}/admin/sales"></order>
@endsection