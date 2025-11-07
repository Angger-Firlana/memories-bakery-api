<?php

namespace App\Http\Employee\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\User;
use App\Http\Employee\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employees = Employee::with('user')->get();
            return response()->json($employees);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => "Error: " . $ex->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $employee = Employee::with('user')->find($id);
            if ($employee) {
                return response()->json($employee);
            } else {
                return response()->json([
                    'message' => "Employee Not Found"
                ], 404);
            }
        } catch (\Exception $ex) {
            return response()->json([
                'message' => "Error: " . $ex->getMessage()
            ], 500);
        }
    }

    public function store(EmployeeRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role_id' => 2
            ]);

            $employee = Employee::create([
                'user_id' => $user->id,
                'branch_id' => $request['branch_id'],
                'fullname' => $request['fullname'],
                'address' => $request['address'],
                'phone_number' => $request['phone_number']
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Employee berhasil ditambahkan",
                'data' => $employee->load('user')
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'message' => "Error: " . $ex->getMessage()
            ], 500);
        }
    }

    public function update(EmployeeRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::findOrFail($id);
            $user = $employee->user;

            // Update data user
            $user->update([
                'username' => $request['username'],
                'email' => $request['email'],
            ]);

            // Kalau password diisi, baru di-update
            if (!empty($request['password'])) {
                $user->update([
                    'password' => Hash::make($request['password']),
                ]);
            }

            // Update data employee
            $employee->update([
                'branch_id' => $request['branch_id'],
                'fullname' => $request['fullname'],
                'address' => $request['address'],
                'phone_number' => $request['phone_number'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Employee berhasil diupdate',
                'data' => $employee->load('user'),
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'message' => "Error: " . $ex->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::findOrFail($id);
            $user = $employee->user;

            // Hapus employee
            $employee->delete();

            // Hapus user juga biar gak orphan
            if ($user) {
                $user->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Employee berhasil dihapus',
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'message' => "Error: " . $ex->getMessage(),
            ], 500);
        }
    }
}
