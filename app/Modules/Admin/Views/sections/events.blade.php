@extends('Admin::master')
@section('content')
    <events ref="events" url="{{ url('') }}" host="{{ url('') }}/admin/events"></events>
@stop
