<?php

namespace App\Http\Delivery\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\PutDeliveryRequest;
use App\Models\Delivery;

class DeliveryController extends Controller
{
    // GET /deliveries
    public function index()
    {
        try {
            $deliveries = Delivery::with(['courier', 'order'])->get();

            return response()->json([
                'success' => true,
                'data' => $deliveries
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to get delivery: {$ex->getMessage()}"
            ], 500);
        }
    }

    // POST /deliveries
    public function store(StoreDeliveryRequest $request)
    {
        try {
            $delivery = Delivery::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Delivery created successfully',
                'data' => $delivery
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to create delivery: {$ex->getMessage()}"
            ], 500);
        }
    }

    // GET /deliveries/{id}
    public function show($id)
    {
        try {
            $delivery = Delivery::with(['courier', 'order'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $delivery
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Delivery not found: {$ex->getMessage()}"
            ], 404);
        }
    }

    // PUT /deliveries/{id}
    public function update(PutDeliveryRequest $request, $id)
    {
        try {
            $delivery = Delivery::findOrFail($id);

            $delivery->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Delivery updated successfully',
                'data' => $delivery
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to update delivery: {$ex->getMessage()}"
            ], 500);
        }
    }

    // DELETE /deliveries/{id}
    public function destroy($id)
    {
        try {
            $delivery = Delivery::findOrFail($id);

            $delivery->delete();

            return response()->json([
                'success' => true,
                'message' => 'Delivery deleted successfully'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to delete delivery: {$ex->getMessage()}"
            ], 500);
        }
    }
    
    public function patch(PutDeliveryRequest $request, $id)
    {
        try {
            $delivery = Delivery::findOrFail($id);

            $delivery->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Delivery patched successfully',
                'data' => $delivery
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to patch delivery: {$ex->getMessage()}"
            ], 500);
        }
    }

    // GET /deliveries/user/{userId}
    // user_id berada di tabel couriers
    public function getByUser($userId)
    {
        try {
            $deliveries = Delivery::whereHas('courier', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->with(['courier', 'order'])->get();

            return response()->json([
                'success' => true,
                'data' => $deliveries
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Failed to get deliveries by user: {$ex->getMessage()}"
            ], 500);
        }
    }
}
