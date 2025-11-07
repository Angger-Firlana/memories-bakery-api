<?php

namespace App\Http\Manager\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Manager\Requests\StoreManagerRequest;
use App\Http\Manager\Requests\UpdateManagerRequest;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = Manager::with(['user', 'branch'])->get();

        return response()->json([
            'success' => true,
            'data' => $managers
        ]);
    }

    public function store(StoreManagerRequest $request)
    {
        DB::beginTransaction();
        try {
            // 1️⃣ Buat user baru
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 4,
            ]);

            // 2️⃣ Buat manager baru
            $manager = Manager::create([
                'user_id' => $user->id,
                'branch_id' => $request->branch_id,
                'fullname' => $request->fullname,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Manager created successfully',
                'data' => $manager->load('user', 'branch')
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create manager',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        $manager = Manager::with(['user', 'branch'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $manager
        ]);
    }

    public function update(UpdateManagerRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $manager = Manager::findOrFail($id);
            $user = $manager->user;

            // 1️⃣ Update user
            $user->username = $request->username;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // 2️⃣ Update manager
            $manager->update([
                'branch_id' => $request->branch_id,
                'fullname' => $request->fullname,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Manager updated successfully',
                'data' => $manager->load('user', 'branch')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update manager',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $manager = Manager::findOrFail($id);
            $user = $manager->user;

            $manager->delete();
            if ($user) $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Manager deleted successfully'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete manager',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
