<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Playlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (!auth()?->check()) {
            return view('guest-home');
        }

        $audios = Audio::currentUser()->get();
        $playlists = Playlist::where('user_id', auth()->id())->get(); 
        return view('home', [
            'audios' => $audios,
            'playlists' => $playlists
        ]);
    }
}
