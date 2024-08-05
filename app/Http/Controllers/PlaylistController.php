<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistShowRequest;
use App\Http\Requests\PlaylistStoreRequest;
use App\Models\Playlist;
use App\Models\Audio;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Add this line
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
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
        //$playlist = Playlist::create($request->validated());

        $isPublic = $request->has('is_public') ? 1 : 0;


        $playlist = [
            'name' => $validated['name'],
            'is_public' => $isPublic,
            'cover_disk' => config('filesystems.default'),
            //'cover_path' => $request->file('cover_path'),
            'user_id' => auth()->id()
        ];


        $playlist['cover_path'] = $request->file('cover_path')->store('covers', $playlist['cover_disk']);


        $playlist = Playlist::create($playlist);

        //dd($playlist->id);


        // Criando um relacionamento fake com a tabela playlist_user
        DB::table('playlist_user')->insert([
            'playlist_id' => $playlist->id,
            'user_id' => auth()->id()
        ]);


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

        // Inserir um novo registro
        DB::table('shareds')->insert([
            'playlist_id' => $request->playlistId,
            'user_id' => $request->user
        ]);

        // Inserir um novo registro
        DB::table('playlist_user')->insert([
            'playlist_id' => $request->playlistId,
            'user_id' => $request->user
        ]);


        return response()->json(['message' => 'Playlist shared!!' . $request->playlistId, 'status' => 200], 200);
    }


}
