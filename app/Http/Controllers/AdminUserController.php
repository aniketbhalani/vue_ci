<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }
    public function show(User $user)
    {


        return response()->json($user);
    }
    public function store(StoreUserRequest $request)
    {

        $data = $request->all();
        $data['password'] = bcrypt($request->input('password'));
        //dd($data);
        User::create($data);

        return response()->json(['message' => 'New User has been created'], 200);
    }

    public function update(UpdateUserRequest $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $password = $request->input('password');

    if ($password) {
        $user->password = bcrypt($password);
    }

    $user->fill($request->except(['password']));

    $user->save();

    return response()->json(['message' => 'User updated successfully']);
}



    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'user deleted successfully']);
    }
}
