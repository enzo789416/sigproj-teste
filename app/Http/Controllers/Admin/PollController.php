<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Option;
use App\Poll;
use Carbon\Carbon;
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

    public function show(Poll $poll)
    {
        $options = Option::where('polls_id', '=',$poll->id)->orderBy('id','asc')->get();
        $total = Option::where('polls_id','=',$poll->id)->sum('qtd_votos');
        return view('admin.poll.show')
        ->with(['poll' => $poll, 'options' => $options,'total'=>$total ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|unique:polls',
            [
                'titulo.required' => 'titulo ja cadastrado no banco, por favor insira outro', // custom message
            ]
        ]);
        $tira_espaco = str_replace(' ', '', $request->input('opcoes'));
        $options = explode(",", $tira_espaco);
        if (count($options) > 2) {
            $poll = new Poll;
            $poll->user_id = Auth::user()->id;
            $poll->titulo = request()->titulo;
            $poll->data_inicio = request()->data_inicio;
            $poll->data_fim = request()->data_fim;
            $dataIni = date('d-m-Y', strtotime($poll->data_inicio));
            $horaIni = date('H:i', strtotime($poll->data_inicio));
            $horaFim = date('H:i', strtotime($poll->data_fim));
            $dataFim = date('d-m-Y', strtotime($poll->data_fim));

            // if (strtotime($dataIni) < strtotime(date('d-m-Y'))) {
            //     return redirect()->route('admin.poll.create')->with('error', 'data de inicio não pode ser menor que a data atual');
            // } elseif (strtotime($dataIni) > strtotime($dataFim)) {
            //     return redirect()->route('admin.poll.create')->with('error', 'data de inicio não pode ser maior que a data fim');
            // } elseif (strtotime($dataFim) < strtotime(date('d-m-Y'))) {
            //     return redirect()->route('admin.poll.create')->with('error', 'data de fim não pode ser menor que a data atual');
            // } elseif (strtotime($dataIni) == strtotime($dataFim)) {
            //     if (strtotime($horaIni) > strtotime($horaFim)) { //hora de inicio nao pode ser maior que hora de fim
            //         return redirect()->route('admin.poll.create')->with('error', 'hora de inicio nao pode ser maior que hora de fim');
            //     }
            //     if (strtotime($horaFim) < strtotime($horaIni)) { //hora de fim nao pode ser menor que hora de inicio
            //         return redirect()->route('admin.poll.create')->with('error', 'hora de fim nao pode ser menor que hora de inicio');
            //     }
            //     if (strtotime($horaFim) == strtotime($horaIni)) {
            //         return redirect()->route('admin.poll.create')->with('error', 'hora de fim nao pode ser igual hora de inicio');
            //     }
            // }

            if ($poll->data_inicio < Carbon::now()) {
                return redirect()->route('admin.poll.create')->with('error', 'data de inicio não pode ser menor que a data atual');
            } elseif ($poll->data_inicio > $poll->data_fim) {
                return redirect()->route('admin.poll.create')->with('error', 'data de inicio não pode ser maior que a data fim');
            } elseif ($poll->data_fim < Carbon::now()) {
                return redirect()->route('admin.poll.create')->with('error', 'data de fim não pode ser menor que a data atual');
            } elseif ($poll->data_inicio == $poll->data_fim) {
                if ($horaIni > $horaFim) { //hora de inicio nao pode ser maior que hora de fim
                    return redirect()->route('admin.poll.create')->with('error', 'hora de inicio nao pode ser maior que hora de fim');
                }
                if ($horaFim < $horaIni) { //hora de fim nao pode ser menor que hora de inicio
                    return redirect()->route('admin.poll.create')->with('error', 'hora de fim nao pode ser menor que hora de inicio');
                }
                if ($horaFim == $horaIni) {
                    return redirect()->route('admin.poll.create')->with('error', 'hora de fim nao pode ser igual hora de inicio');
                }
            }



            $poll->save();
            foreach ($options as $key => $value) {

                $option = new Option;
                $option->polls_id = $poll->id;
                $option->opcao = $value;
                $option->save();
            }
            return redirect()->route('admin.poll.index')->with('success', 'cadastrado com sucesso');
        } else {
            return redirect()->route('admin.poll.create')->with('error', 'devem ser cadastrados no minimo 3 opções');
        }
    }

    public function edit(Poll $poll)
    {
        $options = Option::where('polls_id', '=', $poll->id)->get();
        // $ops = $options->implode("opcao",",");

        return view('admin.poll.edit')->with(['poll' => $poll, 'options' => $options]);
    }

    public function update(Request $request, Poll $poll)
    {
        $pol = Poll::find($poll->id);
        $options = Option::where('polls_id', '=', $poll->id)->get();
        // $cases = [];
        // $ids = [];
        // $params = [];
        // $options = Option::find($poll->id);
        if (isset($pol) && isset($options)) {

            $tira_espaco = str_replace(' ', '', $request->input('opcoes'));
            $opt = explode(",", $tira_espaco);
            if (count($opt) > 2) {

                $pol->user_id = Auth::user()->id;
                $pol->titulo = request()->titulo;
                $pol->data_inicio = request()->data_inicio;
                $pol->data_fim = request()->data_fim;
                $dataIni = date('d-m-Y', strtotime($pol->data_inicio));
                $horaIni = date('H:i', strtotime($pol->data_inicio));
                $horaFim = date('H:i', strtotime($pol->data_fim));
                $dataFim = date('d-m-Y', strtotime($pol->data_fim));

                if ($poll->data_inicio < Carbon::now()) {
                    return redirect()->route('admin.poll.create')->with('error', 'data de inicio não pode ser menor que a data atual');
                } elseif ($poll->data_inicio > $poll->data_fim) {
                    return redirect()->route('admin.poll.create')->with('error', 'data de inicio não pode ser maior que a data fim');
                } elseif ($poll->data_fim < Carbon::now()) {
                    return redirect()->route('admin.poll.create')->with('error', 'data de fim não pode ser menor que a data atual');
                } elseif ($poll->data_inicio == $poll->data_fim) {
                    if ($horaIni > $horaFim) { //hora de inicio nao pode ser maior que hora de fim
                        return redirect()->route('admin.poll.create')->with('error', 'hora de inicio nao pode ser maior que hora de fim');
                    }
                    if ($horaFim < $horaIni) { //hora de fim nao pode ser menor que hora de inicio
                        return redirect()->route('admin.poll.create')->with('error', 'hora de fim nao pode ser menor que hora de inicio');
                    }
                    if ($horaFim == $horaIni) {
                        return redirect()->route('admin.poll.create')->with('error', 'hora de fim nao pode ser igual hora de inicio');
                    }
                }

                $pol->save();
                // foreach  ($options as $id_key => $dados) {
                //     Poll::where(['id' => $id_key])->update($dados);
                // }
                // foreach ($options as $id => $value) {
                //     // $id = (int) $id;
                //     // $cases[] = "WHEN {$id} then ?";
                //     // $params[] = $value;
                //     // $ids[] = $id;
                //     $options->polls_id = $poll->id;
                //     $options->opcao = $value;
                //     $options->save();
                // }
                // DB::update("UPDATE `options` SET `value` = CASE `id` {$cases} END, `updated_at` = ? WHERE `id` in ({$ids})", $params);
                return redirect()->route('admin.poll.index')->with('success', 'atualizado com sucesso');
            } else {
                return redirect()->route('admin.poll.edit', $poll)->with('error', 'devem ser cadastrados no minimo 3 opções');
            }
        }
    }



    public function destroy(Poll $poll)
    {
        $poll->delete();
        return redirect()->route('admin.poll.index')->with('error', $poll->titulo . ' has deleted successfully');
    }
}
