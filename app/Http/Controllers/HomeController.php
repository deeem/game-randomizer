<?php

namespace App\Http\Controllers;

use App\Game;
use App\Platform;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stats = Platform::gamesStats()->sortByDesc('gamesCount');
        $max = $stats->max('gamesCount');
        $games = Game::recentApproved()->take(10)->get();

        return view('dashboard.index', compact('games', 'stats', 'max'));
    }
}
