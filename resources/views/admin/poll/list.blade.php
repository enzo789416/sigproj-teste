@extends('admin.layouts.app')

@section('content')



    <ul class="list-group">
        <li class="list-group-item">
            <h4 class="text-center">Lista de Enquetes</h3>
        </li>
    </ul>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card-body">
                {{-- <div class="form-group row">
                    <div class="col-md-6 mb-4">
                        <a class="btn btn-success" href="{{ route('admin.poll.create') }}" id="createPoll" role="button">Cadastrar Nova
                            enquete</a>
                    </div>
                </div> --}}

                <table id="example" class="display table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>data_inicio</th>
                            <th>data_fim</th>
                            <th>Editar</th>
                            <th>Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($polls ?? '' as $poll)
                            <tr>
                                <td>{{ $poll->id }}</td>
                                <td>{{ $poll->titulo }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime($poll->data_inicio)) }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime($poll->data_fim)) }}</td>
                                <td><a class="btn btn-warning" href="{{route('admin.poll.edit', $poll->id)}}" role="button">
                                        <i class="fas fa-edit"></i>
                                    </a></td>
                                <td>
                                    <form action="{{route('admin.poll.destroy', $poll)}}" id="deletePoll" method="POST" class="float-left">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="PollForm" name="PollForm" class="form-horizontal">
                        <div class="form-group">
                            <label for="">Título:</label>
                            <input type="text" class="form-control" name="titulo" required>
                            <small class="help-block">Digite o título para a enquete.</small>
                          </div>

                          <div class="form-group">
                            <label for="">Data e hora de Inicio:</label>
                            <input type="datetime-local" class="form-control" name="data_inicio" required>
                            <small class="help-block">Digite a data e hora de inicio da votação.</small>
                          </div>

                          <div class="form-group">
                            <label for="">Data e hora de Fim:</label>
                            <input type="datetime-local" class="form-control" name="data_fim" required>
                            <small class="help-block">Digite a data e hora de fim da votação.</small>
                          </div>

                          <div class="form-group">
                            <label for="">Opções:</label>
                            <input type="text" class="form-control" name="opcoes" required>
                            <small class="help-block">Digite no minimo 3 opções para a votação separando por vírgula(,).<br>Exemplo: text-1,text-2,text-3.</small>
                          </div>

                        <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                         </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
