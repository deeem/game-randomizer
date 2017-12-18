<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of latest approved games.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::where('user_id', '!=', null)->latest('updated_at')->take(10)->get();

        return view('dashboard.index', compact('games'));
    }
}
