@extends('Admin::master')
@section('content')
  <dash ref="dash" url="{{ url('') }}" host="{{ url('') }}/admin/painel"></dash>
@endsection
