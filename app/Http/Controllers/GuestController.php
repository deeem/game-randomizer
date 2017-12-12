<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Platform;
use App\Game;

class GuestController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $platforms = Platform::all();

        return view('guest.create', compact('platforms'));
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

        $request->validate([
            'name' => 'required',
            'platform_id' => ['required', Rule::in($platformsIds)]
        ]);

        Game::create([
            'name' => request('name'),
            'platform_id' => request('platform_id')
        ]);

        return redirect('/posted');
    }

    /**
     * Display "Game added" page
     */
    public function displayPostAdded()
    {
        return view('guest.posted');
    }
}
