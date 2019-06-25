@extends('Admin::master')
@section('content')
    <accounts ref="accounts" url="{{ url('') }}" host="{{ url('') }}/admin/accounts"></accounts>
@stop

