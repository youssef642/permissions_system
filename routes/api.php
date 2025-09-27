<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PermissionsController;
use Faker\Provider\ar_EG\Person;

// auth routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');


 Route::middleware('auth:sanctum')->group(function () {
    // users routes
    Route::get('/users', [UsersController::class, 'index'])->middleware('permission:view_users')->name('users.index');
    Route::get('/users/{id}', [UsersController::class, 'show'])->middleware('permission:view_users')->name('users.show');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UsersController::class, 'destroy'])->middleware('permission:delete_users')->name('users.delete');
    Route::post('/users/{id}/assign-group', [UsersController::class, 'assignGroup'])->name('users.assignGroup');

    // groups routes
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::post('/groups', [GroupController::class, 'create'])->middleware('permission:create_groups')->name('groups.create');
    Route::put('/groups/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{id}', [GroupController::class, 'destroy'])->name('groups.delete');
    Route::post('/groups/{id}/assign-permission', [GroupController::class, 'assignPermission'])->name('groups.assignPermission');

    //permissions routes
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
});
