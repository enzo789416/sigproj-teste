@extends('admin.layouts.app')
@section('content')
    <ul class="list-group">
        <li class="list-group-item">
            <h4 class="text-center">Editar Enquete {{ $poll->titulo }}</h3>
        </li>
    </ul>

    <form action="{{ route('admin.poll.update', $poll) }}" method="post">
        @csrf
        {{ method_field('PUT') }}
        <div class="form-group">
            <label for="">Título:</label>
            <input type="text" class="form-control" name="titulo" value="{{ $poll->titulo }}" required>
            <small class="help-block">Digite o título para a enquete.</small>
        </div>

        <div class="form-group">
            <label for="">Data e hora de Inicio:</label>
            <input type="datetime-local" class="form-control" name="data_inicio"
                value="{{ date('Y-m-d\TH:i:s', strtotime($poll->data_inicio)) }}" required>
            <small class="help-block">Digite a data e hora de inicio da votação.</small>
        </div>

        <div class="form-group">
            <label for="">Data e hora de Fim:</label>
            <input type="datetime-local" class="form-control" name="data_fim"
                value="{{ date('Y-m-d\TH:i:s', strtotime($poll->data_fim)) }}" required>
            <small class="help-block">Digite a data e hora de fim da votação.</small>
        </div>

        <div class="form-group">
            <label for="">Opções:</label>
            <input type="text" class="form-control" name="opcoes" value="{{ $options->pluck('opcao')->implode(',') }}"
                required>
            <small class="help-block">Digite no minimo 3 opções para a votação separando por vírgula(,).<br>Exemplo:
                text-1,text-2,text-3.</small>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success float-right">Atualizar</button>
            <a class="btn btn-secondary float-left" href=" {{ route('admin.poll.index') }}" role="button">Voltar</a>
        </div>

    </form>
@endsection
