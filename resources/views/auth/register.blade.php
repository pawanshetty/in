@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
    <div class="col-md-12">
        <h2>
            No Registration, Sorry Man!
        </h2>
    </div>
@stop

@section('adminlte_js')
    @yield('js')
@stop
