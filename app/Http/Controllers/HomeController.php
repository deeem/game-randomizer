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
        // $this->middleware('auth')->except('index');
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
        $suggesters = Game::topSuggesters()->limit(10)->get();
        $approvers = Game::topApprovers()->limit(10)->get();

        return view('dashboard.index', compact('games', 'stats', 'max', 'suggesters', 'approvers'));
    }

    /**
     * Display platforms list
     */
    public function list()
    {
        $platforms = Platform::all();

        return view('randomizer.platforms', compact('platforms'));
    }

    /**
     * Display randomizer
     */
    public function randomizer(Platform $platform)
    {
        $games = Game::approved()->where('platform_id' , $platform->id)->get();
        $game = $games->isNotEmpty() ? $games->random() : null;

        return view('randomizer.result', compact('platform', 'game'));
    }
}
