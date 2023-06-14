<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'user deleted successfully']);
    }
}
