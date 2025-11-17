<?php

namespace App\Http\Production\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production;
use App\Http\Production\Requests\PostProductionRequests;

class ProductionController extends Controller
{
    //
    public function index(Request $request  ){
        $productions = Production::query();
        $productions = $productions->paginate(
            $request->input('pagination', 10),
            ['*'],
            'page',
            $request->input('page', 1)
        );

        return response()->json([
            'success' => true,
            'message' => "Success received data",
            'meta' => [
                'current_page' => $productions->currentPage(),
                'per_page' => $productions->perPage(),
                'total' => $productions->total(),
                'last_page' => $productions->lastPage(),
                'from' => $productions->firstItem(),
                'to' => $productions->lastItem(),
            ],
            'data' => $productions->items(),
        ]);
    }

    public function show($id){
        $production = Production::find($id);

        if(!$production){
            return response()->json([
                'success' => false,
                'message' => "Production not found",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => "Success received data",
            'data' => $production,
        ]);
    }


    public function store(PostProductionRequests $request){
        try{
            $production = Production::create($request->all());

            return response()->json([
                'success' => true,
                'message' => "Production created successfully",
                'data' => $production,
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Failed to create production",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update($id, Request $request){
        $production = Production::find($id);

        try{
            if(!$production){
                return response()->json([
                    'success' => false,
                    'message' => "Production not found",
                ], 404);
            }

            $production->update($request->all());

            return response()->json([
                'success' => true,
                'message' => "Production updated successfully",
                'data' => $production,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Failed to update production",
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    public function destroy($id){
        $production = Production::find($id);

        if(!$production){
            return response()->json([
                'success' => false,
                'message' => "Production not found",
            ], 404);
        }

        $production->delete();

        return response()->json([
            'success' => true,
            'message' => "Production deleted successfully",
        ]);
    }
}
