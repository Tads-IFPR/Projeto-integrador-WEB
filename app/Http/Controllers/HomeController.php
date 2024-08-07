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

        $playlists = auth()->user()->shareds;

        // $playlists_id = DB::table('playlist_user')
        // ->where('user_id', auth()->id())
        // ->get();


        // foreach ($playlists_id as $playlist) {
        //     $finded = Playlist::find($playlist->playlist_id);
        //     $playlists[] = $finded;
        // }

        return view('home', [
            'playlists' => $playlists
        ]);
    }
}
