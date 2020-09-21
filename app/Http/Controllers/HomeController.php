<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Option;
use App\Poll;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $polls = Poll::all();
        $pollsfinalizados = Poll::where('data_fim', '<', Carbon::now())->get();
        $pollsnaoiniciadas = Poll::where('data_inicio', '>', Carbon::now())->get();
        // $pollaberta = Poll::where('')
        return view('home.index')->with(['polls' => $polls, 'pollsfinalizados' => $pollsfinalizados, 'pollsnaoiniciadas' => $pollsnaoiniciadas]); //passa as enquetes para a pagina inicial para o usuario comum poder votas
    }

    public function show(Poll $home)
    {
        $options = Option::where('polls_id', '=', $home->id)->orderBy('id', 'asc')->get();
        $total = Option::where('polls_id', '=', $home->id)->sum('qtd_votos'); //mostra uma enquete em especifico
        return view('home.show')
            ->with(['poll' => $home, 'options' => $options, 'total' => $total]);
    }

    public function update(Request $home)
    {
        if (is_null($home->input('opcao'))) {
        } else {
            $opcao = Option::find($home->input('opcao')); //atualiza os votos de uma enquete, adicionando +1 na opcao que voce escolher
            $opcao->qtd_votos++;
            $opcao->save();
        }
        return back();
    }
}
