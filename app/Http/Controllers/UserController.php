<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function getById($id)
    {
        $user = User::with('vendor')->where('id', $id)->get();
        return response()->json(['user' => $user]);
    }


    public function getAll()
    {
        $user = User::paginate();
        return response()->json($user);
    }
}
