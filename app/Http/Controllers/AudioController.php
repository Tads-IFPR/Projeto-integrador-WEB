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
        $audio = Audio::all();

        return view('audio.index', compact('audio'));
    }

    public function create(Request $request): View
    {
        return view('audio.create');
    }

    public function store(AudioStoreRequest $request): RedirectResponse
    {
        $audio = Audio::create($request->validated());

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
        $audio->update($request->validated());

        return redirect()->route('audio.index');
    }

    public function destroy(Request $request, Audio $audio): RedirectResponse
    {
        $audio->delete();

        return redirect()->route('audio.index');
    }
}
