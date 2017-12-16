<?php

namespace App\Http\Controllers;

use App\Game;
use App\Platform;
use App\Http\Requests\GameRequest;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Platform $platform
     * @return \Illuminate\Http\Response
     */
    public function index(Platform $platform)
    {
        if($platform->exists) {
            $games = $platform->games()->get();
        } else {
            $games = Game::all();
        }

        $platforms = Platform::all();

        return view('game.index', compact('games', 'platforms'));
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
     * @param  \App\Http\Requests\GameRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GameRequest $request)
    {
        $game = Game::create([
            'name' => request('name'),
            'platform_id' => request('platform_id')
        ]);
        $game->user_id = auth()->id();
        $game->save();

        return redirect('games');
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
    public function update(GameRequest $request, Game $game)
    {
        $game->fill($request->all());
        $game->user_id = request('user_id');
        $game->save();

        return redirect('games');
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

        return redirect('games');
    }

    /**
     * Show the form for moderate added game.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function moderate(Game $game)
    {
        $platforms = Platform::all();

        return view('game.moderate', compact('game', 'platforms'));
    }

    /**
     * Update and aprove game after moderator review
     *
     * @param  \App\Http\Requests\GameRequest $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function approve(GameRequest $request, Game $game)
    {
        $game->fill($request->all());
        $game->user_id = auth()->id();
        $game->save();

        return redirect('games');
    }
}
