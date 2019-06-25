@extends('Admin::master')
@section('content')
  <login ref="login" url="{{ url('') }}/admin/login" host="{{ url('') }}/admin/login"></login>
@stop
