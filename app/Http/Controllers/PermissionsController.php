<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }
}
