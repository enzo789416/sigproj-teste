@extends('layouts.app')

@section('content')
<?php use Carbon\Carbon; ?>
    <div class="pt-4 pb-4 d-flex justify-content-center">
        <h2>Enquetes abertas para votação</h2>
    </div>
    <div class="row align-items-start">
    @foreach ($polls ?? '' as $poll)
        @if ($poll->data_inicio < Carbon::now() && $poll->data_fim > Carbon::now() )
                <div class="col-md-4 col-sm-6 col-xs-12 ">
                    <div class="card mb-2 ">
                        <div class="card-body ">
                            <h5 class="card-title d-flex justify-content-center">{{$poll->titulo}}</h5>
                            {{-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}
                            <a href="{{ route('admin.poll.show', $poll->id) }}" class="btn btn-primary  d-flex justify-content-center" role="button">Votar</a>
                        </div>
                    </div>
                </div>
        @endif
    @endforeach
</div>


    <div class="pt-4 pb-4 d-flex justify-content-center">
        <h2>Enquetes Finalizadas</h2>
    </div>

    @foreach ($pollsfinalizados ?? '' as $poll)
            <div class="row align-items-start">
                <div class="col-md-4 col-sm-6 col-xs-12 ">
                    <div class="card mb-2 ">
                        <div class="card-body ">
                            <h5 class="card-title d-flex justify-content-center">{{$poll->titulo}}</h5>
                            {{-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}
                            <a href="{{ route('admin.poll.show', $poll->id) }}" class="btn btn-primary  d-flex justify-content-center" role="button">Votar</a>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach

    <div class="pt-4 pb-4 d-flex justify-content-center">
        <h2>Enquetes Ainda não iniciadas</h2>
    </div>

    <div class="row align-items-start">
        @foreach ($pollsnaoiniciadas ?? '' as $poll)

                    <div class="col-md-4 col-sm-6 col-xs-12 ">
                        <div class="card mb-2 ">
                            <div class="card-body ">
                                <h5 class="card-title d-flex justify-content-center">{{$poll->titulo}}</h5>
                                {{-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}
                                <a href="{{ route('admin.poll.show', $poll->id) }}" class="btn btn-primary  d-flex justify-content-center" role="button">Votar</a>
                            </div>
                        </div>
                    </div>
        @endforeach
    </div>



@endsection
