<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return response()->json($users);
    }
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($request->all());
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function assignGroup(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'group_id' => 'required|integer|exists:groups,id',
        ]);
        if ($user) {
            $user->groups()->sync($request->group_id);
            return response()->json(['message' => 'Group assigned successfully']);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
