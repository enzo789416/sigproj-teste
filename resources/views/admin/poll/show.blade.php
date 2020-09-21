@extends('admin.layouts.app')

@section('content')
    <?php use Carbon\Carbon; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default ">
                <div class="panel-heading text-center  ">
                    <h4>{{ $poll->titulo }}</h4>
                </div>
                @if (Carbon::now() > $poll->data_inicio && Carbon::now() < $poll->data_fim)
                    <div class="d-flex justify-content-center">
                        <form class="" action="{{ url()->current() }}" method="post">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="panel-body">
                                <p>Selecione um das opções abaixo:</p>
                                @foreach ($options ?? '' as $value)
                                    <p><input type="radio" name="opcao" value="{{ $value->id }}"> {{ $value->opcao }}
                                        ({{ 'Total de votos: ' . $value->qtd_votos }})</p>
                                @endforeach
                            </div>
                            <div class="panel-footer ">
                                <button type="submit" disabled class="btn btn-sm btn-success ">Votar</button>
                                <br><br>
                                <p><b>Obs:</b> rota administrativa é somente para visualização!!!</p>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="d-flex justify-content-center">
                        <form class="" action="{{ url()->current() }}" method="post">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="panel-body">
                                <p>A enquete abaixo ainda não está disponivel ou está expirada, verifique as datas da
                                    enquete</p>
                                @foreach ($options ?? '' as $value)
                                    <p><input type="radio" disabled name="opcao" value="{{ $value->id }}">
                                        {{ $value->opcao }}
                                        ({{ 'Total de votos: ' . $value->qtd_votos }})
                                    </p>
                                @endforeach
                            </div>
                            <div class="panel-footer ">
                                <button type="submit" disabled class="btn btn-sm btn-success ">Votar</button>
                            </div>
                        </form>

                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection
