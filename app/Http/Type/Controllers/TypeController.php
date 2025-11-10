<?php

namespace App\Http\Type\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    //
    public function index(){
        $types = Type::orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => "Success received data",
            'data' => $types,
        ]);
    }

    public function show($id){
        try {
            $type = Type::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => "Success received data",
                'data' => $type
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Type not found: {$ex->getMessage()}"
            ], 404);
        }
    }


    public function store(Request $request){
        try {
            $validated = $request->validate([
                'type_name' => 'required|string|max:100|unique:types,type_name',
            ]);

            $type = Type::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Type successfully added',
                'data' => $type
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to add type: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function update(Request $request, $id){
        try {
            $type = Type::findOrFail($id);

            $validated = $request->validate([
                'type_name' => 'required|string|max:100',
            ]);

            $type->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Type successfully updated',
                'data' => $type
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to update type: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $type = Type::findOrFail($id);
            $type->delete();

            return response()->json([
                'success' => true,
                'message' => 'Type successfully deleted'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to delete type: {$ex->getMessage()}"
            ], 500);
        }
    }   
}
