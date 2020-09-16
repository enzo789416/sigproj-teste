<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $poll = Poll::all();
        return view('admin.poll.painel')->with('poll', $poll);
    }

    public function store()
    {
        $poll = new Poll;
        $poll->titulo = request()->titulo;
        $poll->titulo = request()->duracao;
        $poll->titulo = request()->titulo;
    }
}
