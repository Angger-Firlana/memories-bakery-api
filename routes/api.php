<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BranchController;
use App\Http\Middleware\ApiAuthenticate;
use App\Http\Controllers\IngredientsController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/role', [RoleController::class, 'index']);

Route::middleware(['authenticate', 'role:admin'])->group(function (){
    Route::post('branch', [BranchController::class, 'store']);
    Route::put('branch/{id}', [BranchController::class, 'update']);
    Route::delete('branch/{id}', [BranchController::class, 'delete']);

    Route::get('ingredient', [IngredientsController::class, 'index']);
    Route::post('ingredient', [IngredientsController::class, 'store']);
    Route::put('ingredients/{id}', [IngredientsController::class, 'update']);
    Route::patch('ingredients/{id}', [IngredientsController::class, 'patch']);
    Route::delete('ingredients/{id}', [IngredientsController::class, 'destroy']);
    
    Route::get('roles', [RoleController::class, 'index']);
    Route::post('roles', [RoleController::class, 'store']);
    Route::put('roles/{id}', [RoleController::class, 'update']);
    Route::patch('roles/{id}', [RoleController::class, 'patch']);
    Route::delete('roles/{id}', [RoleController::class, 'destroy']);

     Route::get('units', [UnitController::class, 'index']);
    Route::post('units', [UnitController::class, 'store']);
    Route::put('units/{id}', [UnitController::class, 'update']);
    Route::patch('units/{id}', [UnitController::class, 'patch']);
    Route::delete('units/{id}', [UnitController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('branch', [BranchController::class, 'index']);
    Route::get('branch/{id}', [BranchController::class, 'getById']);
});

