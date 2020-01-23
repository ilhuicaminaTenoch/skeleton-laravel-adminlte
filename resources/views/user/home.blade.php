@extends('adminlte::page')
@section('title', 'Dashboard | Lara Admin')

@section('content_header')
    <h1>Usuarios</h1>
@stop


@section('content')
        <div class="row justify-content-center">
            <div class="col-12">
                <usuarios></usuarios>
            </div>
        </div>
@endsection
