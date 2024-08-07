<?php

namespace App\Http\Controllers;

use App\Models\Playlist;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function __invoke(Request $request)
    {

        $playlists = [];


        if (!auth()?->check()) {
            return view('guest-home');
        }

        return view('home');
    }
}
