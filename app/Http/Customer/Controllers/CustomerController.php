<?php

namespace App\Http\Customer\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Http\Customer\Requests\CustomerRequest;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('user')->get();

        if ($customers->isNotEmpty()) {
            return response()->json($customers);
        } else {
            return response()->json([
                'message' => "Customer kosong, isi dulu"
            ], 404);
        }
    }

    public function store(CustomerRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'username'=> $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role_id' => 3
            ]);

            $customer = Customer::create([
                'user_id' => $user->id,
                'fullname' => $request['fullname'],
                'quickname' => $request['quickname'],
                'address' => $request['address'],
                'phone_number' => $request['phone_number']
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil menambah data customer",
                'data' => $customer->load('user')
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create customer',
                'error' => $ex->getMessage(),
            ], 500);
        }
    }

    public function showByUserID($id){
        try{
            $customer = Customer::where('user_id', $id)->first();
            
            if (!$customer) {
                return response()->json([
                    'message' => 'Customer not found'
                ], 404);
            }
            
            return response()->json($customer);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to get customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(CustomerRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $customer = Customer::findOrFail($id);
            $user = $customer->user;

            // update user
            $user->update([
                'username'=> $request['username'],
                'email' => $request['email'],
            ]);

            // kalau ada password baru
            if (!empty($request['password'])) {
                $user->update([
                    'password' => Hash::make($request['password']),
                ]);
            }

            // update customer
            $customer->update([
                'fullname' => $request['fullname'],
                'quickname' => $request['quickname'],
                'address' => $request['address'],
                'phone_number' => $request['phone_number'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah data customer',
                'data' => $customer->load('user'),
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to update customer',
                'error' => $ex->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $customer = Customer::findOrFail($id);
            $user = $customer->user;

            // hapus customer dulu
            $customer->delete();

            // hapus user-nya juga biar gak orphan
            if ($user) {
                $user->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data customer'
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to delete customer',
                'error' => $ex->getMessage(),
            ], 500);
        }
    }
}
