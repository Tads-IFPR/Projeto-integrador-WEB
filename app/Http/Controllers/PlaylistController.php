<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistStoreRequest;
use App\Http\Requests\PlaylistUpdateRequest;
use App\Models\Playlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlaylistController extends Controller
{
    /*public function index(Request $request): View
    {
        $playlists = Playlist::all();

        return view('playlist.index', compact('playlists'));
    }*/

    public function create(Request $request): View
    {
        return view('playlist.create');
    }

    public function store(PlaylistStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        //$playlist = Playlist::create($request->validated());

        $isPublic = $request->has('is_public') ? 1 : 0;


        $playlist = [
            'name' => $validated['name'],
            'is_public' => $isPublic,
            'cover_path' => $validated['cover_path'],
            'cover_disk' => $validated['cover_disk'],
            'user_id' => auth()->id(),
        ];

    
        $playlist = Playlist::create($playlist);
        

        return redirect()->route('home');
    }

    public function show(Request $request, Playlist $playlist): View
    {
        $request->validate();

        
        
        return view('playlist.show', compact('playlist'));
    }

    public function edit(Request $request, Playlist $playlist): View
    {
        return view('playlist.edit', compact('playlist'));
    }

    public function update(PlaylistUpdateRequest $request, Playlist $playlist): RedirectResponse
    {
        $playlist->update($request->validated());

        return redirect()->route('playlist.index');
    }

    public function destroy(Request $request, Playlist $playlist): RedirectResponse
    {
        $playlist->delete();

        return redirect()->route('playlist.index');
    }
}
