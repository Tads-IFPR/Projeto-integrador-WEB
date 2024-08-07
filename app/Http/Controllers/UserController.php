<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

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

        auth()->user()->update($validated);

        return redirect()->route('home');
    }
}
