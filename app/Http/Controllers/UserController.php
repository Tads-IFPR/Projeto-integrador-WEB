<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function getAll(Request $request)
    {
        // if (!auth()?->check()) {
        //     return view('guest-home');
        // }

        $users = User::all();


        return $users;
    }

    public function getByName(Request $request)
    {
        // if (!auth()?->check()) {
        //     return view('guest-home');
        // }

        $name = $request->name;

        $users = User::where('name', 'like', '%' . $name. '%')
        ->whereNot('name', '<=>', auth()->user()->name)
        ->get();


        return response()->json($users);

    }
}
