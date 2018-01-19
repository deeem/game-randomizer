<?php

namespace App\Http\Controllers;

use App\Game;
use App\Platform;
use App\Suggester;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Platform $platform
     * @return \Illuminate\Http\Response
     */
    public function index(Platform $platform)
    {
        if (! $platform->exists()) {
            abort(404);
        }

        $games = $platform->games()->get()->sortBy('name');
        $name = $platform->name;

        return view('game.index', compact('games', 'name'));
    }

    /**
     * Display a list of the games need to approving
     *
     * @return \Illuminate\Http\Response
     */
    public function suggested()
    {
        $games = Game::unapproved()->get();

        return view('game.suggested', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $platforms = Platform::all();

        return view('game.create', compact('platforms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGameRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $gameData = $request->only(['name', 'platform_id']);
        $suggesterData = [
            'name' => request('suggester_name'),
            'email' => request('suggester_email'),
        ];

        $game = Game::create($gameData);

        if (auth()->check() && auth()->user()->hasAccess(['approve-game'])) {
            $user = auth()->user();
            $suggester = Suggester::firstOrCreate([
                'name' => $user->name,
                'email' => $user->email
            ]);

            $game->suggester_id = $suggester->id;
        } else {
            if ($suggesterData['name'] || $suggesterData['email']) {
                $suggester = Suggester::firstOrCreate($suggesterData);

                $game->suggester_id = $suggester->id;
            } else {
                $game->suggester_id = null;
            }
        }

        $game->user_id = auth()->id();
        $game->save();

        return redirect()->route('home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        $platforms = Platform::all();

        return view('game.edit', compact('game', 'platforms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\GameRequest $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        $game->name = request('name');
        $game->platform_id = request('platform_id');
        $game->user_id = request('user_id');
        $game->save();

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        Game::destroy($game->id);

        return back();
    }

    /**
     * Update and aprove game after moderator review
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function approve(Game $game)
    {
        $game->user_id = auth()->id();
        $game->save();

        return back();
    }
}
