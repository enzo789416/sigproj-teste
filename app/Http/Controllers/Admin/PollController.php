<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Option;
use App\Poll;
use Illuminate\Http\Request;
use App\DataTables\PollDataTable;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        // $poll = Poll::all();
        // return view('')->with('poll', $poll);
    }

    public function create()
    {
        return view('admin.poll.create');
    }

    public function store(Request $request)
    {
        $poll = new Poll;
        $poll->user_id = Auth::user()->id;
        $poll->titulo = request()->titulo;
        $poll->data_inicio = request()->data_inicio;
        $poll->data_fim = request()->data_fim;
        $poll->save();

        $options = explode(",",$request->input('opcoes'));
        foreach ($options as $key => $value){
            $option = new Option;
            $option->polls_id = $poll->id;
            $option->opcao = $value;
            $option->save();
        }
        return back();
    }
}
