<?php

namespace App\Http\Menu\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Http\Menu\Requests\StoreMenuRequest;
use App\Http\Controllers\Controller;
use App\Http\Menu\Requests\UpdateMenuRequest;

class MenuController extends Controller
{
    //
    public function index(Request $request){
        $pagination = $request->input('pagination', 10);
        $page = $request->input('page', 1);
        
        $menus = Menu::orderBy('created_at', 'desc')->with('branch')->paginate($pagination, ['*'], 'page', $page);
        return response()->json([
            'success' => true,
            'message' => "Success received data",
            'current_page' => $menus->currentPage(),
            'per_page' => $menus->perPage(),
            'total' => $menus->total(),
            'last_page' => $menus->lastPage(),
            'data' => $menus->items(),
        ]);
    }

    public function show($id){
        try {
            $menu = Menu::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => "Success received data",
                'data' => $menu
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Menu not found: {$ex->getMessage()}"
            ], 404);
        }
    }

    public function store(StoreMenuRequest $request){
        DB::beginTransaction();
        try {

            $menu = Menu::create([
                'type_id' => $request->type_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'validDuration' => $request->validDuration,
                'branch_id' => $request->branch_id,
                'stock' => $request->stock,
            ]);

            // Simpan detail menu
            foreach($request->details as $detail){
                $menu->menu_details()->create([
                    'menu_id' => $menu->id,
                    'ingredient_id' => $detail['ingredient_id'],
                    'quantity' => $detail['quantity'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Menu successfully added',
                'data' => $menu
            ], 201);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Failed to add menu: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function update(UpdateMenuRequest $request, $id){
        DB::beginTransaction();
        try {
            $menu = Menu::findOrFail($id);

            $menu->update([
                'type_id' => $request->type_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'validDuration' => $request->validDuration,
                'branch_id' => $request->branch_id,
                'stock' => $request->stock,
            ]);
            
            if($request->has('details')){
                // Hapus detail menu lama
                $menu->menu_details()->delete();
                // Simpan detail menu baru
                foreach($request->details as $detail){
                    $menu->menu_details()->create([
                        'menu_id' => $menu->id,
                        'ingredient_id' => $detail['ingredient_id'],
                        'quantity' => $detail['quantity']
                    ]);
                }
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Menu successfully updated',
                'data' => $menu
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Failed to update menu: {$ex->getMessage()}"
            ], 500);
        }
    }   

    public function destroy($id){
        try {
            $menu = Menu::findOrFail($id);
            $menu->delete();

            return response()->json([
                'success' => true,
                'message' => 'Menu successfully deleted'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to delete menu: {$ex->getMessage()}"
            ], 500);
        }
    }
}