@extends('layouts.app')

@section('content')
<?php use Carbon\Carbon; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h4>{{$poll->titulo}}</h4>
                    </div>

                    <form class="" action="{!!  url()->current() !!}" method="post">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <div class="panel-body">
                            <p>Selecione um das opções abaixo:</p>
                            @foreach ($options ?? '' as $value)
                                <p><input type="radio" name="opcao" value="{{ $value->id }}"> {{  $value->opcao }}
                                    ({{'Total de votos: ' . $value->qtd_votos }})</p>
                            @endforeach
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-sm btn-success">Votar</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>

@endsection
