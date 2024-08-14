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
        $audios = Audio::all(); // Carrega todos os áudios
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


        $playlist['cover_path'] = $request->file('cover_path')->store('covers', $playlist['cover_disk']);

        $playlist = Playlist::create($playlist);

        return redirect()->route('home');
    }


    public function edit(Request $request, Playlist $playlist): View
    {
        return view('playlist.edit', compact('playlist'));
    }

    public function update(Request $request, $id){


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

    public function show(PlaylistShowRequest $request, Playlist $playlist)
    {
        $request->validated();

        return view('playlist.show', compact('playlist'));
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
        $playlist = Playlist::with('audios')->findOrFail($id);
        $playlists = Playlist::all();
        $audios = Audio::all();

        return view('playlist.show', compact('playlist', 'playlists', 'audios', 'id'));
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

        return redirect()->route('playlist.show', $playlist->id)->with('message', 'Audio removed successfully.');
    }

    public function share(Request $request)
    {
        // Verificando se a playlist e o usuário existe
        $validated = $request->validate([
            'playlistId' => 'required|exists:playlists,id',
            'sharedUserId' => 'required|exists:users,id'
        ]);

        // Verificando se já existe um compartilhamento entre a playlist e o usuário
        $playlist = Playlist::find($validated['playlistId']);
        $alreadyShared = $playlist->shareds()->where('user_id', $validated['sharedUserId'])->exists();

        if ($alreadyShared) {
            return response()->json(['message' => 'Playlist já compartilhada com este usuário.', 'status' => 409], 409);
        }

        // Inserir na tabela 'shareds' o id da playlist e o id do usuário que compartilhou
        $playlist = Playlist::find($validated['playlistId']);
        $playlist->shareds()->attach($validated['sharedUserId']);


        return response()->json(['message' => 'Playlist shared!' . $request->playlistId . " - - " . $request->sharedUserId, 'status' => 200], 200);
    }

    public function getSharedUsers($playlistId)
{
    $playlist = Playlist::findOrFail($playlistId);
    $sharedUserIds = $playlist->shareds()->pluck('user_id');

    return response()->json($sharedUserIds);
}
}
