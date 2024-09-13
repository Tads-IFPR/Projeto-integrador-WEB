<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistShowRequest;
use App\Http\Requests\PlaylistStoreRequest;
use App\Models\Playlist;
use App\Models\Audio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class PlaylistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id): View
    {
        $audios = Audio::all(); 
        return view('playlist.index', compact('audios'));
    }

    public function create(Request $request): View
    {
        return view('playlist.create');
    }

    public function store(PlaylistStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $isPublic = $request->has('is_public') ? 1 : 0;


        $playlist = [
            'name' => $validated['name'],
            'is_public' => $isPublic,
            'cover_disk' => config('filesystems.default'),
            'user_id' => auth()->id()
        ];

        if($request->hasFile('cover_path')){
            $playlist['cover_path'] = $request->file('cover_path')->store('covers', $playlist['cover_disk']);
        }
        else{
            $playlist['cover_path'] = null;
        }
        $playlist = Playlist::create($playlist);
        
        return redirect()->route('home');
    }


    public function edit(Request $request, Playlist $playlist): View
    {
        return view('playlist.edit', compact('playlist'));
    }

    public function update(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->name = $request->input('name');
        $playlist->is_public = $request->has('is_public');
        
        if ($request->hasFile('cover_path')) {
            $path = $request->file('cover_path')->store('covers');
            $playlist->cover_path = $path;
        }

        $playlist['cover_disk'] = config('filesystems.default');
        $playlist->save();

        return redirect()->route('home')->with('success', 'Playlist atualizada com sucesso!');
    }

    public function destroy(Request $request, Playlist $playlist): RedirectResponse
    {
        $playlist->delete();

        return redirect()->route('home');
    }

    

    public function showImage(PlaylistShowRequest $request, Playlist $playlist)
    {   
        $request->validated();

        $data = explode('/', $playlist->cover_path);
        $extension = $data[array_key_last($data)];
        $path = 'temp/cover' . uniqid() . '.' . $extension;

        Storage::put($path, $playlist->cover());
    
        return response()->file(storage_path('app/' . $path))->deleteFileAfterSend();    
    }

    public function play($id){

        $user = auth()->user();
        $playlist = Playlist::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('is_public', true);
        })
        ->with(['audios' => function ($query) use ($user) {
            $query->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('is_public', true);
            })
            ->with('user');
        }])
        ->findOrFail($id);
        
        $audios = $playlist->audios->sortBy('id')->values();

        return view('playlist.show', compact('playlist', 'audios'))->with('isPlaylistShow', true);
    }
   
    public function addAudio(Request $request)
    {
        $playlist = Playlist::findOrFail($request->playlist_id);
        $audioIds = $request->audio_ids;

        if ($audioIds) {
            $playlist->audios()->attach($audioIds);
        }

        return response()->json(['status' => 'success', 'message' => 'Áudios adicionados com sucesso.']);
    }

    public function filterAudios(Request $request, $id)
    {
        $playlist = Playlist::with('audios')->findOrFail($id);
        $query = $request->input('query');
    
        $filteredAudios = Audio::where('name', 'like', '%' . $query . '%')
            ->whereDoesntHave('playlists', function ($q) use ($playlist) {
                $q->where('playlist_id', $playlist->id);
            })->get();
    
        return view('playlist.partials.audio_list', compact('playlist', 'filteredAudios'));
    }

    public function removeAudio(Playlist $playlist, $audio)
    {
        $playlist->audios()->detach($audio);

        return redirect()->route('playlist.show', $playlist->id);
    }
}
