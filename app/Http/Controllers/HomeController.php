<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;
use App\Poll;

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
        return view('home')->with('polls', $polls);
    }
}
