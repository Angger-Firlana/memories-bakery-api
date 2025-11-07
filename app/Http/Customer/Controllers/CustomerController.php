<?php

namespace App\Http\Customer\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
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
        
    }
}
