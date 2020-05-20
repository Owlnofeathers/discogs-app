<?php

namespace App\Http\Controllers;

use App\Services\DiscogsService;

class HomeController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        if ($user->discogs_username) {
            return (new DiscogsService())->getCollection($user->discogs_username);
        }

        return view('home');
    }
}
