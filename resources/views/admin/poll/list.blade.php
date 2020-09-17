@extends('admin.layouts.app')

@section('content')
<ul class="list-group">
  <li class="list-group-item"><h4 class="text-center">Lista de Enquetes</h3></li>
</ul>
<div class="container">
    <h1></h1>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>id</th>
                <th>Titulo</th>
                <th>Data Inicio</th>
                <th>Data Fim</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(function () {

      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('admin.poll.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'titulo', name: 'name'},
              {data: 'data inicio', name: 'data_inicio'},
              {data: 'data fim', name: 'data_fim'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

    });
  </script>
<div class="row">

  <div class="col-md-6">
    {{-- <div class="well text-center">
      Quantidade de Temas Abertos:
    </div>
  </div>

  <div class="col-md-6">
    <div class="well text-center">
      Quantidade de Temas Encerrados:
    </div>
  </div> --}}
</div>
@endsection
