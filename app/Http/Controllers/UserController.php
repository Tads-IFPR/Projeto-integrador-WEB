<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
}
