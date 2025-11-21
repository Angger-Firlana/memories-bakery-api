<?php

namespace App\Http\Ingredient\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientsController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();

        return response()->json([
            'success' => true,
            'message' => "Success received data",
            'data' => $ingredients
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'unit_id' => 'required|exists:units,id',
                'name' => 'required|string',
                'price' => ['required', 'numeric', 'min:0'],
                'stock' => 'sometimes|integer|min:0',
            ]);

            $ingredient = Ingredient::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Ingredient successfully added',
                'data' => $ingredient
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to add ingredient: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $ingredient = Ingredient::findOrFail($id);

            $validated = $request->validate([
                'unit_id' => 'required|exists:units,id',
                'name' => 'required|string',
                'price' => ['required', 'numeric', 'min:0'],
                'stock' => 'sometimes|integer|min:0',
            ]);

            $ingredient->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Ingredient successfully updated',
                'data' => $ingredient
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ingredient not found'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to update ingredient: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function patch(Request $request, $id)
    {
        try {
            $ingredient = Ingredient::findOrFail($id);

            // validasi opsional
            $validated = $request->validate([
                'unit_id' => 'sometimes|exists:units,id',
                'name' => 'sometimes|string',
                'price' => ['sometimes', 'numeric', 'min:0'],
                'stock' => 'sometimes|integer|min:0',
            ]);

            $ingredient->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Ingredient successfully patched',
                'data' => $ingredient
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ingredient not found'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to patch ingredient: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $ingredient = Ingredient::findOrFail($id);
            $ingredient->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ingredient successfully deleted'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ingredient not found'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to delete ingredient: {$ex->getMessage()}"
            ], 500);
        }
    }
}
