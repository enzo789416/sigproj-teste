<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Option;
use App\Poll;
use Illuminate\Contracts\Session\Session;
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
        // $polls = DB::table('polls')->get();
        // return view('admin.poll.list',compact('polls'));
        $polls = Poll::all();
        return view('admin.poll.list')->with('polls', $polls);
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
            $dataIni = date('d-m-Y', strtotime($poll->data_inicio));
            $horaIni = date('H:i', strtotime($poll->data_inicio));
            $horaFim = date('H:i', strtotime($poll->data_fim));
            $dataFim = date('d-m-Y', strtotime($poll->data_fim));

            if (strtotime($dataIni) < strtotime(date('d-m-Y'))) {
                return redirect()->route('admin.poll.create')->with('error','data de inicio não pode ser menor que a data atual');
            }elseif (strtotime($dataIni) > strtotime($dataFim)) {
                return redirect()->route('admin.poll.create')->with('error','data de inicio não pode ser maior que a data fim');
            } elseif (strtotime($dataFim) < strtotime(date('d-m-Y'))) {
                return redirect()->route('admin.poll.create')->with('error','data de fim não pode ser menor que a data atual');
            }elseif (strtotime($dataIni) == strtotime($dataFim)) {
                if (strtotime($horaIni) > strtotime($horaFim) ){ //hora de inicio nao pode ser maior que hora de fim
                    return redirect()->route('admin.poll.create')->with('error','hora de inicio nao pode ser maior que hora de fim');
                }
                if(strtotime($horaFim) < strtotime($horaIni)){ //hora de fim nao pode ser menor que hora de inicio
                    return redirect()->route('admin.poll.create')->with('error','hora de fim nao pode ser menor que hora de inicio');
                }
                if (strtotime($horaFim) == strtotime($horaIni)){
                    return redirect()->route('admin.poll.create')->with('error','hora de fim nao pode ser igual hora de inicio');
                }
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

    public function edit(Poll $poll)
    {
        $options = Option::where('polls_id', '=', $poll->id )->get();
        // $ops = $options->implode("opcao",",");

        return view('admin.poll.edit')->with(['poll' => $poll, 'options'=>$options]);
    }

    public function update(Request $request, Poll $poll)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return redirect()->route('admin.user.index')->with('success',$user->name.' has updated successfully!');
    }



    public function destroy(Poll $poll)
    {

        $poll->delete();
        return redirect()->route('admin.poll.index')->with('error', $poll->titulo.' has deleted successfully');
    }
}
