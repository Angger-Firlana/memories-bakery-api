<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            return response()->json([
                'success' => true,
                'message' => "Berhasil ambil data",
                'data' => $roles
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Gagal ambil data: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'role_name' => 'required|string|max:50|unique:roles,role_name',
            ]);

            $role = Role::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Role berhasil ditambahkan',
                'data' => $role
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Gagal menambahkan role: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);

            $validated = $request->validate([
                'role_name' => 'required|string|max:50|unique:roles,role_name,' . $id,
            ]);

            $role->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Role berhasil diupdate',
                'data' => $role
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak ditemukan'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Gagal mengupdate role: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function patch(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);

            $validated = $request->validate([
                'role_name' => 'sometimes|string|max:50|unique:roles,role_name,' . $id,
            ]);

            $role->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Role berhasil diupdate sebagian',
                'data' => $role
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak ditemukan'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Gagal patch role: {$ex->getMessage()}"
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role berhasil dihapus'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak ditemukan'
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => "Gagal menghapus role: {$ex->getMessage()}"
            ], 500);
        }
    }
}
