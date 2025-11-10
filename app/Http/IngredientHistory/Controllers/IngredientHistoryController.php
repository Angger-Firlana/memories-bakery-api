<?php

namespace App\Http\IngredientHistory\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IngredientsHistory;


class IngredientHistoryController extends Controller
{
    //
    public function index(Request $request)
    {
        // Ambil parameter dari query string
        $branchId = $request->input('branch_id'); // contoh ?branch_id=2
        $perPage  = $request->input('per_page', 10); // default 10 item per halaman

        // Query dasar
        $query = IngredientsHistory::query();

        // Filter berdasarkan branch kalau ada
        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        // Pagination
        $ingredientHistories = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Response JSON
        return response()->json([
            'success' => true,
            'message' => "Success received data",
            'current_page' => $ingredientHistories->currentPage(),
            'per_page' => $ingredientHistories->perPage(),
            'total' => $ingredientHistories->total(),
            'last_page' => $ingredientHistories->lastPage(),
            'data' => $ingredientHistories->items(), // ambil data per halaman
        ]);
    }

    public function show($id)
    {
        try {
            $ingredientHistory = IngredientsHistory::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => "Success received data",
                'data' => $ingredientHistory
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Ingredient history not found: {$ex->getMessage()}"
            ], 404);
        }
    }


    public function store(Request $request){
        try {
            $validated = $request->validate([
                'branch_id' => 'required|exists:branchs,id',
                'ingredient_id' => 'required|exists:ingredients,id',
                'received_date' => 'required|date',
                'quantity' => 'required|integer|min:1',
                'expired_date' => 'required|date|after:received_date',
                'status' => 'required|string|max:50'
            ]);

            $ingredientHistory = IngredientsHistory::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Ingredient history successfully added',
                'data' => $ingredientHistory
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to add ingredient history: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function update(Request $request, $id){
        try {
            $ingredientHistory = IngredientsHistory::findOrFail($id);

            $validated = $request->validate([
                'branch_id' => 'required|exists:branchs,id',
                'ingredient_id' => 'required|exists:ingredients,id',
                'received_date' => 'required|date',
                'quantity' => 'required|integer|min:1',
                'expired_date' => 'required|date|after:received_date',
                'status' => 'required|string|max:50'
            ]);

            $ingredientHistory->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Ingredient history successfully updated',
                'data' => $ingredientHistory
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ingredient history not found'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to update ingredient history: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function getStockByBranchAndIngredient($branchId, $ingredientId){
        try {
            $totalStock = IngredientsHistory::where('branch_id', $branchId)
                ->where('ingredient_id', $ingredientId)
                ->where('status', 'new_stock')
                ->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => "Success received stock data",
                'data' => [
                    'branch_id' => $branchId,
                    'ingredient_id' => $ingredientId,
                    'total_stock' => $totalStock
                ]
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to retrieve stock data: {$ex->getMessage()}"
            ], 500);
        }
    }


    public function destroy($id){
        try {
            $ingredientHistory = IngredientsHistory::findOrFail($id);
            $ingredientHistory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ingredient history successfully deleted'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ingredient history not found'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to delete ingredient history: {$ex->getMessage()}"
            ], 500);
        }
    }   

}
