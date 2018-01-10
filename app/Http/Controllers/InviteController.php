<?php

namespace App\Http\Controllers;

use App\User;
use App\Invite;
use App\Role;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth')->except('accept');
    }

    /**
     * Display list of invites
     */
    public function index()
    {
        $invites = Invite::all();

        return view('invite.index', compact('invites'));
    }

    /**
     * Show the user form with email field to invite a new user
     */
    public function create()
    {
        return view('invite.create');
    }

    /**
     * Process the form submission and send the invite by email
     */
    public function process(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = request('email');

        do {
            $token = str_random();
        } //check if token already exists and if it does, try again
        while (Invite::where('token', $token)->first());

        $invite = Invite::create([
            'email' => $email,
            'token' => $token
        ]);

        Mail::to($email)->send(new InviteCreated($invite));

        return redirect('/invites');
    }

    /**
     * Here we'll look up the user by the token sen provider in the URL
     */
    public function accept($token)
    {
        if (! $invite = Invite::where('token', $token)->first()) {
            abort(404);
        }

        $email = $invite->email;
        $password = str_random();

        $user = User::create([
            'email' => $email,
            'name' => 'user-' . uniqid(),
            'password' => bcrypt($password)
        ]);
        $role = Role::where('slug', 'games')->first();
        $user->roles()->attach($role);

        Auth::attempt(['email' => $email, 'password' => $password]);

        $invite->delete();

        return redirect("/users/{$user->id}/edit");
    }

    /**
     * Remove the specified invite from storage.
     */
    public function destroy(Invite $invite)
    {
        Invite::destroy($invite->id);

        return redirect('invites');
    }

}
