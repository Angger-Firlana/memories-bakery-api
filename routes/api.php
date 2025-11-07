<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserMiddleware;
use App\Http\Auth\Controllers\AuthController;
use App\Http\Role\Controllers\RoleController;
use App\Http\Branch\Controllers\BranchController;
use App\Http\Unit\Controllers\UnitController;
use App\Http\Middleware\ApiAuthenticate;
use App\Http\Ingredient\Controllers\IngredientsController;
use App\Http\Customer\Controllers\CustomerController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/role', [RoleController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function (){

    Route::get('customers', [CustomerController::class, 'index']);
    Route::post('customers', [CustomerController::class, 'store']);
    Route::put('customers/{id}', [CustomerController::class, 'update']);
    Route::delete('customers/{id}', [CustomerController::class, 'destroy']);

    Route::post('branch', [BranchController::class, 'store']);
    Route::put('branch/{id}', [BranchController::class, 'update']);
    Route::delete('branch/{id}', [BranchController::class, 'destroy']);

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

