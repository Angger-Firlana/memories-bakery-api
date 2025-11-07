<?php

namespace App\Http\Courier\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Courier\Requests\StoreCourierRequest;
use App\Http\Courier\Requests\UpdateCourierRequest;
use App\Models\Courier;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CourierController extends Controller
{
    public function index()
    {
        $couriers = Courier::with(['user', 'branch'])->get();

        return response()->json([
            'success' => true,
            'data' => $couriers
        ]);
    }

    public function store(StoreCourierRequest $request)
    {
        DB::beginTransaction();
        try {
            // 1️⃣ Buat user baru
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 5, // misal role courier
            ]);

            // 2️⃣ Buat courier baru
            $courier = Courier::create([
                'user_id' => $user->id,
                'branch_id' => $request->branch_id,
                'fullname' => $request->fullname,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Courier created successfully',
                'data' => $courier->load('user', 'branch')
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create courier',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        $courier = Courier::with(['user', 'branch'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $courier
        ]);
    }

    public function update(UpdateCourierRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $courier = Courier::findOrFail($id);
            $user = $courier->user;

            // 1️⃣ Update user
            $user->username = $request->username;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // 2️⃣ Update courier
            $courier->update([
                'branch_id' => $request->branch_id,
                'fullname' => $request->fullname,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Courier updated successfully',
                'data' => $courier->load('user', 'branch')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update courier',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $courier = Courier::findOrFail($id);
            $user = $courier->user;

            $courier->delete();
            if ($user) $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Courier deleted successfully'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete courier',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
