<?php

namespace App\Http\Controllers;

use App\Game;
use App\Platform;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('create', 'store');
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
            $games = Game::unapproved()->get();
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
     * @param  \App\Http\Requests\StoreGameRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
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
    public function update(UpdateGameRequest $request, Game $game)
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
     * Update and aprove game after moderator review
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function approve(Game $game)
    {
        $game->user_id = auth()->id();
        $game->save();

        return redirect('games');
    }
}
