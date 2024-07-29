<?php

namespace App\Http\Controllers;

use App\Http\Requests\AudioShowRequest;
use App\Http\Requests\AudioStoreRequest;
use App\Http\Requests\AudioUpdateRequest;
use App\Models\Audio;
use App\Models\Playlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AudioController extends Controller
{
    public function create(Request $request): View
    {
        return view('audio.create');
    }

    public function store(AudioStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $audio = [
            'name' => $validated['name'],
            'author' => $validated['artist'],
            'user_id' => auth()->id(),
        ];

        $audio['disk'] = config('filesystems.default');
        $audio['path'] = $request->file('file')->store('audios', $audio['disk']);

        $getID3 = new \getID3;
        $file = $getID3->analyze(storage_path('app') . '/' .$audio['path']);
        $audio['duration'] = ceil($file['playtime_seconds']);

        if ($request->hasFile('cover')) {
            $audio['cover_disk'] = config('filesystems.default');
            $audio['cover_path'] = $request->file('cover')->store('covers', $audio['cover_disk']);
        }

        if (!$audio['name']) {
            $audio['name'] = $request->file('file')->getClientOriginalName();
            $audio['name'] = str_replace("." . $request->file('file')->getClientOriginalExtension(), '', $audio['name']);
        }

        $audio = Audio::create($audio);

        return redirect()->route('home');
    }

    public function show(AudioShowRequest $request, Audio $audio)
    {
        $request->validated();

        $data = explode('/', $audio->path);
        $extension = $data[array_key_last($data)];
        $path = 'temp/audio' . uniqid() . '.' . $extension;

        Storage::put($path, $audio->file());

        return response()->file(storage_path('app/') . $path)->deleteFileAfterSend();
    }

    public function showImage(AudioShowRequest $request, Audio $audio)
    {
        $request->validated();

        $data = explode('/', $audio->path);
        $extension = $data[array_key_last($data)];
        $path = 'temp/cover' . uniqid() . '.' . $extension;

        Storage::put($path, $audio->cover());

        return response()->file(storage_path('app/') . $path)->deleteFileAfterSend();
    }

    public function edit(Request $request, Audio $audio): View
    {
        return view('audio.edit', compact('audio'));
    }

    public function update(AudioUpdateRequest $request, Audio $audio): RedirectResponse
    {
        $validatedData = $request->validated();

        $audioData = [
            'name' => $validatedData['name'],
            'author' => $validatedData['artist'],
        ];

        if (!$audioData['name']) {
            $audioData['name'] = $request->file('file')->getClientOriginalName();
            $audioData['name'] = str_replace("." . $request->file('file')->getClientOriginalExtension(), '', $audioData['name']);
        }
        if ($request->hasFile('cover')) {
            $audioData['cover_disk'] = config('filesystems.default');
            $audioData['cover_path'] = $request->file('cover')->store('covers', $audioData['cover_disk']);
        }
        if ($request->hasFile('file')) {
            $getID3 = new \getID3;
            $audioData['disk'] = config('filesystems.default');
            $audioData['path'] = $request->file('file')->store('audios', $audioData['disk']);
            $file = $getID3->analyze(storage_path('app') . '/' .$audioData['path']);
            $audioData['duration'] = ceil($file['playtime_seconds']);
        }

        $audio->update($audioData);

        return redirect()->route('home');
    }

    public function destroy(Request $request, Audio $audio): RedirectResponse
    {
        Storage::disk($audio->disk)->delete($audio->path);
        Storage::disk($audio->cover_disk)->delete($audio->cover_path);
        $audio->delete();

        return redirect()->route('home');
    }

    public function showPlaylist(Request $request, Audio $audio): RedirectResponse
    {
        {
            $validated = $request->validate([
                'playlist_id' => 'required|exists:playlists,id',
            ]);
    
            $playlist = Playlist::findOrFail($validated['playlist_id']);
            $playlist->audios()->attach($audio->id);
    
            return redirect()->route('home')->with('success', 'Áudio adicionado à playlist com sucesso.');
        }
    }


}
