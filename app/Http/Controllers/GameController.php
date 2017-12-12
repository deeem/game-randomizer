<?php

namespace App\Http\Controllers;

use App\Game;
use App\Platform;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::all();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $platformsIds = Platform::all()->pluck('id')->toArray();

        $validatedData = $request->validate([
            'name' => 'required',
            'platform_id' => ['required', Rule::in($platformsIds)]
        ]);

        $game = Game::create($validatedData);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $platformsIds = Platform::all()->pluck('id')->toArray();
        $usersIds = User::all()->pluck('id')->toArray();

        $validatedData = $request->validate([
            'name' => 'required',
            'platform_id' => ['required', Rule::in($platformsIds)],
            'user_id' => ['nullable', Rule::in($usersIds)]
        ]);

        $game->fill($validatedData);

        if (! $game->user_id) {
            $game->user_id = request('user_id');
        }

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

        return view('game.review', compact('game', 'platforms'));
    }
}
