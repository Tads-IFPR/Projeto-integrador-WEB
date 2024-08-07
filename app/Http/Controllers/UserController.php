<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function getAll(Request $request)
    {

        $users = User::all();


        return $users;
    }

    public function getByName(Request $request)
    {

        $name = $request->name;

        $users = User::where('name', 'like', '%' . $name. '%')
        ->whereNot('name', '<=>', auth()->user()->name)
        ->get();

        return response()->json($users);

    }

    public function __invoke(Request $request)
    {
        if (!Auth::check()) {
            return view('guest-home');
        }

        $user = Auth::user();

        $playlists = $user->playlists;

        return view('home', [
            'playlists' => $playlists
        ]);
    }

}
