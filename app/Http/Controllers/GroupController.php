<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::paginate(5);
        return response()->json($groups);
    }
    public function show($id)
    {
        $group = Group::find($id);
        if ($group) {
            return response()->json($group);
        } else {
            return response()->json(['message' => 'Group not found'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $group = Group::find($id);
        if ($group) {
            $request->validate([
                'name' => 'sometimes|required|string|max:255|unique:groups,name,' . $id,
                'description' => 'sometimes|nullable|string',
            ]);
            $group->update($request->all());
            return response()->json($group);
        } else {
            return response()->json(['message' => 'Group not found'], 404);
        }
    }
    public function destroy($id)
    {
        $group = Group::find($id);
        if ($group) {
            $group->delete();
            return response()->json(['message' => 'Group deleted successfully']);
        } else {
            return response()->json(['message' => 'Group not found'], 404);
        }
    }
    public function create(Request $request)
    {
    if ($request->user()->role !== 'admin') {
        return response()->json(['message' => 'Forbidden, you do not have permission to create groups.'], 403);
    }
        $request->validate([
            'name' => 'required|string|max:255|unique:groups,name',
            'description' => 'nullable|string',
        ]);
        $group = Group::create($request->all());
        return response()->json($group, 201);
    }

    public function assignPermission(Request $request, $id)
    {
        $group = Group::find($id);
        $request->validate([
            'permission_id' => 'required|integer|exists:permissions,id',
        ]);
        if ($group) {
            $group->permissions()->syncWithoutDetaching($request->permission_id);
            return response()->json(['message' => 'Permission assigned successfully']);
        } else {
                return response()->json(['message' => 'Group not found'], 404);
        }
    }


 
    

}
