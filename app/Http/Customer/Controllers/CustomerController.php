<?php

namespace App\Http\Customer\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;      // ✅ untuk transaksi database
use Illuminate\Support\Facades\Hash;    // ✅ untuk enkripsi password
use App\Models\User;                    // ✅ untuk model User
use App\Models\Customer;                // ✅ untuk model Customer
use App\Http\Customer\Requests\CustomerRequest; // ✅ namespace-nya sesuaikan dengan struktur kamu

class CustomerController extends Controller
{
    //
    public function index(){
        $customers = Customer::all();

        if(!$customers->empty()){
            return response()->json(
                $customers
            );
        }else{
            return response()->json([
                'message' => "customer kosong, isi dulu"
            ], 404);
        }
        
    }

    public function store(CustomerRequest $request){
        DB::beginTransaction(); 
        try{
            $user = User::create([
                'username'=> $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role_id' => 3
            ]);

            $customer = Customer::create([
                'user_id' => $user['id'],
                'fullname' => $request['fullname'],
                'quickname' =>$request['quickname'],
                'address' => $request['address'],
                'phone_number' => $request['phone_number']
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil menambah data customer",
                'data' => $customer->load('user')
            ]);
        }catch(\Exception $ex){
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create customer',
                'error' => $ex->getMessage(),
            ], 500);
        }
    }
}
