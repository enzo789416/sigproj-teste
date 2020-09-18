@extends('layouts.app')

@section('content')
    <div class="pt-4 pb-4 d-flex justify-content-center">
        <h2>Enquetes abertas para votação</h2>
    </div>
    <div class="row align-items-start">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Votar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-4 pb-4 d-flex justify-content-center">
        <h2>Enquetes Finalizadas</h2>
    </div>

    <div class="row align-items-start">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Ver resultado</a>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4 pb-4 d-flex justify-content-center">
        <h2>Enquetes Ainda não iniciadas</h2>
    </div>

    <div class="row align-items-start">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Ver enquete</a>
                </div>
            </div>
        </div>
    </div>

    

@endsection
