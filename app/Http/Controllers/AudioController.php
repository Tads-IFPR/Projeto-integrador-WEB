<?php

namespace App\Http\Controllers;

use App\Http\Requests\AudioStoreRequest;
use App\Http\Requests\AudioUpdateRequest;
use App\Models\Audio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AudioController extends Controller
{
    public function index(Request $request): View
    {
        $audios = Audio::all();

        return view('audio.index', compact('audios'));
    }

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

        return redirect()->route('audio.index');
    }

    public function show(Request $request, Audio $audio): View
    {
        return view('audio.show', compact('audio'));
    }

    public function edit(Request $request, Audio $audio): View
    {
        return view('audio.edit', compact('audio'));
    }

    public function update(AudioUpdateRequest $request, Audio $audio): RedirectResponse
    {
        $validatedData = $request->validated();

        $audio->update([
            'name' => $validatedData['name'],
            'author' => $validatedData['artist'],
        ]);

        if (!$audio['name']) {
            $audio['name'] = $request->file('file')->getClientOriginalName();
            $audio['name'] = str_replace("." . $request->file('file')->getClientOriginalExtension(), '', $audio['name']);
        }
        if ($request->hasFile('cover')) {
            $audio['cover_disk'] = config('filesystems.default');
            $audio['cover_path'] = $request->file('cover')->store('covers', $audio['cover_disk']);
        }
        if ($request->hasFile('file')) {
            $getID3 = new \getID3;
            $audio['disk'] = config('filesystems.default');
            $audio['path'] = $request->file('file')->store('audios', $audio['disk']);
            $file = $getID3->analyze(storage_path('app') . '/' .$audio['path']);
            $audio['duration'] = ceil($file['playtime_seconds']);
        }

        return redirect()->route('audio.index');
    }

    public function destroy(Request $request, Audio $audio): RedirectResponse
    {
        $audio->delete();

        return redirect()->route('audio.index');
    }
}
