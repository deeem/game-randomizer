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
        $stats = Platform::gamesStats();

        $max = array_reduce(array_values($stats), function ($acc, $item) {
            return $item > $acc ? $item : $acc;
        }, 0);

        $games = Game::recentApproved()->take(10)->get();

        return view('dashboard.index', compact('games', 'stats', 'max'));
    }
}
