<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit; // pastikan model Unit sudah dibuat

class UnitController extends Controller
{
    public function index()
    {
        try {
            $units = Unit::all();

            return response()->json([
                'success' => true,
                'message' => "Success received data",
                'data' => $units
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to get data: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'unit_name' => 'required|string|max:50|unique:units,unit_name'
            ]);

            $unit = Unit::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Unit successfully added',
                'data' => $unit
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to add unit: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $unit = Unit::findOrFail($id);

            $validated = $request->validate([
                'unit_name' => 'required|string|max:50|unique:units,unit_name,' . $id
            ]);

            $unit->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Unit successfully updated',
                'data' => $unit
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unit not found'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to update unit: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function patch(Request $request, $id)
    {
        try {
            $unit = Unit::findOrFail($id);

            $validated = $request->validate([
                'unit_name' => 'sometimes|string|max:50|unique:units,unit_name,' . $id
            ]);

            $unit->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Unit successfully patched',
                'data' => $unit
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unit not found'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to patch unit: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $unit = Unit::findOrFail($id);
            $unit->delete();

            return response()->json([
                'success' => true,
                'message' => 'Unit successfully deleted'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unit not found'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to delete unit: {$ex->getMessage()}"
            ], 500);
        }
    }
}
