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
        $countGames = function() {
            $counts = [];
            $platforms = Platform::all();
            foreach($platforms as $platform) {
                $counts[$platform->name] = $platform->games->count();
            }

            return $counts;
        };

        $counts = $countGames();

        $max = array_reduce(array_values($counts), function ($acc, $item) {
            return $item > $acc ? $item : $acc;
        }, 0);

        $games = Game::where('user_id', '!=', null)->latest('updated_at')->take(10)->get();

        return view('dashboard.index', compact('games', 'counts', 'max'));
    }
}
