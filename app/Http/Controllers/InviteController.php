<?php

namespace App\Http\Controllers;

use App\User;
use App\Invite;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    /**
     * Show the user form with email field to invite a new user
     */
    public function invite()
    {
        return view('invite.create');
    }

    /**
     * Process the form submission and send the invite by email
     */
    public function process(Request $request)
    {
        // validate the incoming request data
        $email = request('email');

        do {
            // generate a random string using Laravel's str_random helper
            $token = str_random();
        } //check if token already exists and if it does, try again
        while (Invite::where('token', $token)->first());

        // create a new invite record
        $invite = Invite::create([
            'email' => $email,
            'token' => $token
        ]);

        // send the email
        Mail::to($email)->send(new InviteCreated($invite));

        // redirect back where we cam socket_recvfrom

        return redirect()->back();
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

        Auth::attempt(['email' => $email, 'password' => $password]);

        $invite->delete();

        return redirect("/users/{$user->id}/edit");
    }
}
