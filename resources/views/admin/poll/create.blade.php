@extends('admin.layouts.app')
@section('content')
<ul class="list-group">
  <li class="list-group-item"><h4 class="text-center">Adicionar Enquetes</h3></li>
</ul>

<form action="{{route('admin.poll.store')}}" method="post">
  {!! csrf_field() !!}
  <div class="form-group">
    <label for="">Título:</label>
    <input type="text" class="form-control" name="titulo">
    <small class="help-block">Digite o título para a enquete.</small>
  </div>

  <div class="form-group">
    <label for="">Data e hora de Inicio:</label>
    <input type="datetime-local" class="form-control" name="data_inicio">
    <small class="help-block">Digite a data e hora de inicio da votação.</small>
  </div>

  <div class="form-group">
    <label for="">Data e hora de Fim:</label>
    <input type="datetime-local" class="form-control" name="data_fim">
    <small class="help-block">Digite a data e hora de fim da votação.</small>
  </div>

  <div class="form-group">
    <label for="">Opções:</label>
    <input type="text" class="form-control" name="opcoes">
    <small class="help-block">Digite as opções para a votação separando por vírgula(,).<br>Exemplo: text-1,text-2.</small>
  </div>

  <button type="submit" class="btn btn-success">Adicionar</button>
</form>
@endsection
