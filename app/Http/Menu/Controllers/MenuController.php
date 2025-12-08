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
        
       $menus = Menu::orderBy('created_at', 'desc')
            ->with('branch','type')
            ->paginate($pagination, ['*'], 'page', $page)->appends($request->except('page'));

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
            $menu = Menu::findOrFail($id)->with('branch','type', 'menu_details', 'menu_details.ingredient')->get();
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

    public function store(StoreMenuRequest $request)
    {
        DB::beginTransaction();
        try {

            // Create Menu
            $menu = Menu::create([
                'type_id' => $request->type_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'validDuration' => $request->validDuration,
                'branch_id' => $request->branch_id,
                'stock' => $request->stock,
            ]);

            // Save Details
            foreach ($request->details as $detail) {
                $menu->menu_details()->create([
                    'menu_id' => $menu->id,
                    'ingredient_id' => $detail['ingredient_id'],
                    'quantity' => $detail['quantity'],
                ]);
            }

            // Save Photo (optional)
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('menu_photos', 'public');
                $menu->update(['photo' => $path]);
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

    public function update(UpdateMenuRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $menu = Menu::findOrFail($id);

            // Update Menu
            $menu->update([
                'type_id' => $request->type_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'validDuration' => $request->validDuration,
                'branch_id' => $request->branch_id,
                'stock' => $request->stock,
            ]);

            // Update Details (optional)
            if ($request->has('details')) {

                // delete old details
                $menu->menu_details()->delete();

                // save new details
                foreach ($request->details as $detail) {
                    $menu->menu_details()->create([
                        'menu_id' => $menu->id,
                        'ingredient_id' => $detail['ingredient_id'],
                        'quantity' => $detail['quantity']
                    ]);
                }
            }

            // Update photo (optional)
            if ($request->hasFile('photo')) {

                // delete old photo if exists
                if ($menu->photo && \Storage::disk('public')->exists($menu->photo)) {
                    \Storage::disk('public')->delete($menu->photo);
                }

                // upload new photo
                $path = $request->file('photo')->store('menu_photos', 'public');
                $menu->update(['photo' => $path]);
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