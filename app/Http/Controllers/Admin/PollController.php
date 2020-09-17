<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Option;
use App\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\ElseIf_;

class PollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     return view('');
    //     // $poll = Poll::all();
    //     // return view('')->with('poll', $poll);
    // }

    public function index()
    {
        $polls = DB::table('polls')->get();
        return view('admin.poll.list',compact('polls'));
    }

    public function create()
    {
        return view('admin.poll.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|unique:polls',
            [
                'titulo.required'=> 'titulo ja cadastrado no banco, por favor insira outro', // custom message
            ]
        ]);
        $options = explode(",",$request->input('opcoes'));
        if (count($options) >= 3 ){
            $poll = new Poll;
            $poll->user_id = Auth::user()->id;
            $poll->titulo = request()->titulo;
            $poll->data_inicio = request()->data_inicio;
            $poll->data_fim = request()->data_fim;

            if (date('d-m-Y', strtotime($poll->data_inicio)) < date('d-m-Y')) {
                return redirect()->route('admin.poll.create')->with('error','data de inicio não pode ser menor que a data atual');
            }elseif (date('d-m-Y', strtotime($poll->data_inicio)) > date('d-m-Y', strtotime($poll->data_fim))) {
                return redirect()->route('admin.poll.create')->with('error','data de inicio não pode ser maior que a data fim');
            } elseif (date('d-m-Y', strtotime($poll->data_fim)) < date('d-m-Y')) {
                return redirect()->route('admin.poll.create')->with('error','data de fim não pode ser menor que a data atual');
            }elseif (date('H:i', strtotime($poll->data_inicio)) > date('H:i', strtotime($poll->data_fim))  ){ //hora de inicio nao pode ser maior que hora de fim
                return redirect()->route('admin.poll.create')->with('error','hora de inicio nao pode ser maior que hora de fim');
            }elseif(date('H:i', strtotime($poll->data_fim)) < date('H:i', strtotime($poll->data_inicio))){ //hora de fim nao pode ser menor que hora de inicio
                return redirect()->route('admin.poll.create')->with('error','hora de fim nao pode ser menor que hora de inicio');
            }elseif(date('H:i', strtotime($poll->data_fim)) < date('H:i')){//hora de fim nao pode ser menor que a hora atual
                return redirect()->route('admin.poll.create')->with('error','hora de fim nao pode ser menor que a hora atual');
            }else if(date('H:i', strtotime($poll->data_inicio)) < date('H:i')){ //hora de inicio nao pode ser menor que a hora atual
                return redirect()->route('admin.poll.create')->with('error','hora de inicio nao pode ser menor que a hora atual');
            }

            $poll->save();
            foreach ($options as $key => $value){

                $option = new Option;
                $option->polls_id = $poll->id;
                $option->opcao = $value;
                $option->save();
            }
            return redirect()->route('admin.poll.index');
        }else{
            return redirect()->route('admin.poll.create')->with('error','devem ser cadastrados no minimo 3 opções');
        }



    }
}
