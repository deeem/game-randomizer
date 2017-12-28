<?php

namespace App\Http\Controllers;

use App\User;
use App\Invite;
use App\Mail\InviteCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    /**
     * Show the user form with email field to invite a new user
     */
    public function invite()
    {
        return view('user.invite');
    }

    /**
     * Process the form submission and send the invite by email
     */
    public function process(Request $request)
    {
        // validate the incoming request data

        do {
            // generate a random string using Laravel's str_random helper
            $token = str_random();
        } //check if token already exists and if it does, try again
        while (Invite::where('token', $token)->first());

        // create a new invite record
        $invite = Invite::create([
            'email' => $request->get('email'),
            'token' => $token
        ]);

        // send the email
        Mail::to($request->get('email'))->send(new InviteCreated($invite));

        // redirect back where we cam socket_recvfrom

        return redirect()->back();
    }

    /**
     * Here we'll look up the user by the token sen provider in the URL
     */
    public function accept($token)
    {
        // Look up the invite
        if (! $invite = Invite::where('token', $token)->first()) {
            // if the invite doesn't exists do something more graceful than this
            abort(404);
        }

        // create the user with the details from the invite
        User::create([
            'email' => $invite->email,
            'name' => 'user-' . uniqid(),
            'password' => bcrypt('secret')
        ]);

        // delete the invite so it can't be used again
        $invite->delete();

        // here you would probably log user in and show them them dashboard, but we'll prove it worked

        return 'Good job! Invite accepted!';
    }
}
