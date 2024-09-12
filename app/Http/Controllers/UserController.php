<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function edit(User $user)
    {
        return view('user.edit', [
            'user' => $user
        ]);
    }

    public function update(UserUpdateRequest $request)
    {
        $validated = $request->validated();

        auth()->user()->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($validated['password']) {
            auth()->user()->password = Hash::make($validated['password']);
        }

        auth()->user()->save();

        return redirect()->route('home');
    }
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
