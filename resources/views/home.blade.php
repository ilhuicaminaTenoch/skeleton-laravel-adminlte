@extends('adminlte::page')
@section('title', 'Dashboard | Lara Admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <example-component></example-component>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard test</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
