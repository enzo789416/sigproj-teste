@extends('admin.layouts.app')

@section('content')


<?php use Carbon\Carbon; ?>
    <ul class="list-group">
        <li class="list-group-item">
            <h4 class="text-center">Lista de Enquetes em andamento</h3>
        </li>
    </ul>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card-body">
                {{-- <div class="form-group row">
                    <div class="col-md-6 mb-4">
                        <a class="btn btn-success" href="{{ route('admin.poll.create') }}" id="createPoll"
                            role="button">Cadastrar Nova
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
                            <th>visualizar</th>
                            <th>Editar</th>
                            <th>Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($polls ?? '' as $poll)
                            @if (Carbon::now() > $poll->data_inicio && Carbon::now() < $poll->data_fim  )
                                <tr>
                                    <td>{{ $poll->id }}</td>
                                    <td>{{ $poll->titulo }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($poll->data_inicio)) }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($poll->data_fim)) }}</td>
                                    <td><a class="btn btn-info d-flex justify-content-center" href="{{ route('admin.poll.show', $poll->id) }}"
                                            role="button">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                    <td><a class="btn btn-warning d-flex justify-content-center" href="{{ route('admin.poll.edit', $poll->id) }}"
                                            role="button">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.poll.destroy', $poll) }}" id="deletePoll" method="POST"
                                            class="d-flex justify-content-center">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger d-flex justify-content-center"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
