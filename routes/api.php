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
use App\Http\Employee\Controllers\EmployeeController;
use App\Http\Manager\Controllers\ManagerController;
use App\Http\Courier\Controllers\CourierController;
use App\Http\IngredientHistory\Controllers\IngredientHistoryController;
use App\Http\Type\Controllers\TypeController;
use App\Http\Menu\Controllers\MenuController;
use App\Http\ProductionSchedule\Controllers\ProductionScheduleController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/role', [RoleController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function (){
    Route::apiResource('managers', ManagerController::class);
    Route::apiResource('couriers', CourierController::class);

    //Customer Endpoint
    Route::get('customers', [CustomerController::class, 'index']);
    Route::post('customers', [CustomerController::class, 'store']);
    Route::put('customers/{id}', [CustomerController::class, 'update']);
    Route::delete('customers/{id}', [CustomerController::class, 'destroy']);

    //Employees Endpoint
    Route::get('employees/{id}', [EmployeeController::class, 'show']);
    Route::get('employees', [EmployeeController::class, 'index']);
    Route::put('employees/{id}', [EmployeeController::class, 'update']);
    Route::post('employees', [EmployeeController::class, 'store']);
    Route::delete('employees/{id}', [EmployeeController::class, 'destroy']);
    
    //Branch Endpoint
    Route::post('branch', [BranchController::class, 'store']);
    Route::put('branch/{id}', [BranchController::class, 'update']);
    Route::delete('branch/{id}', [BranchController::class, 'destroy']);

    //Ingredient Endpoint
    Route::get('ingredient', [IngredientsController::class, 'index']);
    Route::post('ingredient', [IngredientsController::class, 'store']);
    Route::put('ingredients/{id}', [IngredientsController::class, 'update']);
    Route::patch('ingredients/{id}', [IngredientsController::class, 'patch']);
    Route::delete('ingredients/{id}', [IngredientsController::class, 'destroy']);
    
    //Role Endpoint
    Route::get('roles', [RoleController::class, 'index']);
    Route::post('roles', [RoleController::class, 'store']);
    Route::put('roles/{id}', [RoleController::class, 'update']);
    Route::patch('roles/{id}', [RoleController::class, 'patch']);
    Route::delete('roles/{id}', [RoleController::class, 'destroy']);

    //Unit Endpoint
    Route::get('units', [UnitController::class, 'index']);
    Route::post('units', [UnitController::class, 'store']);
    Route::put('units/{id}', [UnitController::class, 'update']);
    Route::patch('units/{id}', [UnitController::class, 'patch']);
    Route::delete('units/{id}', [UnitController::class, 'destroy']);

    //Ingredient History Endpoiint
    Route::get('ingredient-history', [IngredientHistoryController::class, 'index']);
    Route::get('ingredient-history/{id}', [IngredientHistoryController::class, 'show']);
    Route::get('ingredient-stock/{branchId}/{ingredientId}', [IngredientHistoryController::class, 'getStockByBranchAndIngredient']);
    Route::post('ingredient-history', [IngredientHistoryController::class, 'store']);
    Route::put('ingredient-history/{id}', [IngredientHistoryController::class, 'update']);
    Route::delete('ingredient-history/{id}', [IngredientHistoryController::class, 'destroy']);

    Route::get('types', [TypeController::class, 'index']);
    Route::get('types/{id}', [TypeController::class, 'show']);
    Route::post('types', [TypeController::class, 'store']);
    Route::put('types/{id}', [TypeController::class, 'update']);
    Route::delete('types/{id}', [TypeController::class, 'destroy']);

    Route::get('menus', [MenuController::class, 'index']);
    Route::get('menus/{id}', [MenuController::class, 'show']);
    Route::post('menus', [MenuController::class, 'store']);
    Route::put('menus/{id}', [MenuController::class, 'update']);
    Route::delete('menus/{id}', [MenuController::class, 'destroy']);

    Route::prefix('production-schedules')->group(function () {
        Route::get('/', [ProductionScheduleController::class, 'index']);
        Route::get('/{id}', [ProductionScheduleController::class, 'show']);
        Route::post('/', [ProductionScheduleController::class, 'store']);
        Route::put('/{id}', [ProductionScheduleController::class, 'update']);
        Route::delete('/{id}', [ProductionScheduleController::class, 'destroy']);
    });
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('branch', [BranchController::class, 'index']);
    Route::get('branch/{id}', [BranchController::class, 'getById']);
});

