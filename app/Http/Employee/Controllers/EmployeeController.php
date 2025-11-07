<?php

namespace App\Http\Employee\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\User;
use App\Http\Employee\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
            $employees = Employee::all();
            return response()->json([
                $employees
            ]);
        }catch(\Exception $ex){
            return response()->json([
                'message' => "Error : $ex"
            ], 500);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        DB::beginTransaction();
        try{
            $user = User::create([
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => $request['password'],
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
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'message' => "Error : $ex"
            ], 500);
        }
        //
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
