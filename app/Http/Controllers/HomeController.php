<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;
use App\Poll;
use Carbon\Carbon;

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
        $poll = Poll::all();
        $pollsfinalizados = Poll::where('data_fim', '<',Carbon::now())->get();
        $pollsnaoiniciadas = Poll::where('data_inicio', '>',Carbon::now())->get();
        return view('home')->with(['polls' => $polls,'pollsfinalizados' => $pollsfinalizados, 'pollsnaoiniciadas'=>$pollsnaoiniciadas]);
    }
}
