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
                        <a class="btn btn-success" href="{{ route('admin.poll.create') }}" role="button">Cadastrar Nova
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
                                <td><a class="btn btn-warning" href="admin/poll/{{ $poll->id }}/edit" role="button">
                                        <i class="fas fa-edit"></i>
                                    </a></td>
                                <td><a class="btn btn-danger glyphicon glyphicon-pencil" href="admin/poll/{{ $poll->id }}"
                                        role="button"><i class="far fa-trash-alt"></i></a></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
