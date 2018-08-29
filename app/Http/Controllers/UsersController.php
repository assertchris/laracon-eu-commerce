<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function showSubscribe(
        /* \Illuminate\View\Factory $view 
        \Illuminate\Config\Repository $config*/
    ) {
        // return $view->make('users.subscribe');
        // return app('view')->make('users.subscribe');
        // return View::make('users.subscribe');
        return view('users.subscribe'/*, [
            'key' => $config->get('services.stripe.key'),
        ]*/);
    }

    public function doSubscribe(Request $request, $token)
    {
        $user = auth()->user();

        $user
            ->newSubscription('Friendly Name', 'stripe-id')
            ->create($token);

        return redirect()->route('users.showSubscribe');
    }
}
