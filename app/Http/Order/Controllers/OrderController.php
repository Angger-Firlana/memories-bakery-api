<?php

namespace App\Http\Order\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Order\Requests\StoreOrderRequest;
use App\Http\Order\Requests\UpdateOrderRequest;
use App\Models\OrderDetail;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $orders = Order::query();
        $orders = $orders->paginate(
            $request->input('pagination', 10),
            ['*'],
            'page',
            $request->input('page', 1)
        );

        return response()->json([
            'success' => true,
            'message' => "Success received data",
            'meta' => [
                'current_page' => $orders->currentPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
                'last_page' => $orders->lastPage(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem(),
            ],
            'data' => $orders->items(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
        DB::beginTransaction();
        try{
            $order = Order::create([
                'branch_id' => $request->branch_id,
                'customer_id' => $request->customer_id ?? null,
                'employee_id' => $request->employee_id,
                'customer_name' => $request->customer_name,
                'order_date' => $request->order_date,
                'address' => $request->address,
                'customer_phone' => $request->customer_phone,
                'status' => $request->status,
            ]);

            foreach($request->details as $orderDetail){
                $menu = Menu::findOrFail($orderDetail['menu_id']);
                $orderDetail = OrderDetail::create([
                    'order_id' => $order->id,
                    'menu_id' => $orderDetail['menu_id'],
                    'quantity' => $orderDetail['quantity'],
                    'sub_total' => $orderDetail['quantity'] * $menu->price,
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Success created order",
                'data' => $order,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Failed to create order",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $order = Order::find($id);
        if(!$order){
            return response()->json([
                'success' => false,
                'message' => "Order not found",
            ], 404);
        } 

        return response()->json([
            'success' => true,
            'message' => "Success received data",
            'data' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $id)
    {
        DB::beginTransaction();
        try {

            $order = Order::findOrFail($id);

            // Update data order utama
            $order->update([
                'branch_id' => $request->branch_id,
                'customer_id' => $request->customer_id,
                'employee_id' => $request->employee_id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'order_date' => $request->order_date,
                'address' => $request->address,
                'status' => $request->status,
            ]);

            // Hapus detail lama
            OrderDetail::where('order_id', $order->id)->delete();

            // Insert detail baru
            foreach ($request->details as $item) {
                $menu = Menu::findOrFail($item['menu_id']);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'sub_total' => $item['quantity'] * $menu->price,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully',
                'data' => $order->load('details')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {

            $order = Order::findOrFail($id);

            // Hapus detail lama
            OrderDetail::where('order_id', $order->id)->delete();

            // Hapus order utama
            $order->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
