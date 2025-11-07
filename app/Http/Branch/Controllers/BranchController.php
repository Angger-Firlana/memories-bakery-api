<?php

namespace App\Http\Branch\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    // 🧩 GET all branches
    public function index()
    {
        try {
            $branches = Branch::all();

            return response()->json([
                'success' => true,
                'message' => 'Success received data',
                'data' => $branches
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Error: {$ex->getMessage()}"
            ], 404);
        }
    }

    public function getById($id){
        $branch = Branch::find($id);
        if($branch != null){
            return response()->json([
                'success' => true,
                'message' => 'Success received data',
                'data' => $branch
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }
    }

    // ➕ POST - Add new branch
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'open' => 'required|integer|min:0|max:23',
                'close' => 'required|integer|min:0|max:23',
                'phone_number' => 'required|string|max:20',
                'email' => 'required|email|unique:branchs,email',
            ]);

            $branch = Branch::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Success add new branch',
                'data' => $branch
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to add new branch: {$ex->getMessage()}"
            ], 404);
        }
    }

    // ✏️ PUT/PATCH - Update branch
    public function update(Request $request, $id)
    {
        try {
            $branch = Branch::findOrFail($id);

            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'open' => 'required|integer|min:0|max:23',
                'close' => 'required|integer|min:0|max:23',
                'phone_number' => 'required|string|max:20',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('branchs', 'email')->ignore($id)
                ],
            ]);

            // Update data
            $branch->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Branch updated successfully',
                'data' => $branch
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response()->json([
                'success' => false,
                'message' => "Branch with ID $id not found"
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to update branch: {$ex->getMessage()}"
            ]);
        }
    }
    

    // ❌ DELETE - optional tambahan
    public function destroy($id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branch->delete();

            return response()->json([
                'success' => true,
                'message' => 'Branch deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response()->json([
                'success' => false,
                'message' => "Branch with ID $id not found"
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to delete branch: {$ex->getMessage()}"
            ]);
        }
    }
}

