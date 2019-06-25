@extends('Admin::master')
@section('content')
    <produtos ref="product" url="{{ url('') }}" api="{{ url('') }}/admin/product"></produtos>
@stop