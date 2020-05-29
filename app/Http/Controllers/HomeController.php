<?php

namespace App\Http\Controllers;

use App\Services\DiscogsService;

class HomeController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        $items = [];
        if ($user->discogs_username) {
            $items = (new DiscogsService())->getCollection($user->discogs_username);
        }

        return view('home', $items);
    }
}
