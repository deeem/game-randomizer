<?php

namespace App\Http\Controllers;

use App\Game;
use App\Platform;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
        return view('randomizer.result', compact('platform'));
    }

    /**
     * Randomizer JSON response
     */
    public function randomize($platform_id)
    {
        if (! $platform_id) {
            abort(404);
        }

        $platform = Platform::find($platform_id);
        $games = $platform->games()->approved()->get()->random(5);

        $response = [];
        foreach($games as $game) {
            $response[] = (object)[
                'name' => $game->name,
                'suggester' => $game->suggester->name,
                'platform' => $game->platform->name,
                'enabled' => true,
                'class' => 'randomizer-item-enabled',
            ];
        }

        return $response;
    }
}
