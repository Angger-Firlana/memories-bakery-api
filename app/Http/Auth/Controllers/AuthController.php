<?php

namespace App\Http\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Requests\CustomerRequest;
use Exception;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        try{
            $validate = $request->validate([
                'login' => 'required',
                'password' => 'required'
            ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL)? 'email' : 'username';
        $credentials = [$loginType => $request->login, 'password' => $request->password];

        if(!Auth::attempt($credentials)){
            return response()->json([
                'success' => false,
                'message' => "Email/username atau password salah"
            ], 404);
        }

        $user = Auth::user();
        $role = $user->role->role_name ?? 'user'; // default user kalau gak ada role
        $tokenName = $role . '_token';

        $user->tokens()->delete();

        $token = $user->createToken($tokenName, [$role])->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => "Berhasil Login",
            'user' => $user,
            'token' => $token
        ], 200);
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

     public function register(CustomerRequest $request)
    {
        try {
            // ✅ Validasi input
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $validated = $validator->validated();

            // ✅ Simpan user baru (customer)
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => 3, // contoh: 3 = customer
                'remember_token' => Str::random(60),
            ]);

            // ✅ Hapus token lama (jaga-jaga)
            $user->tokens()->delete();

            // ✅ Buat token untuk customer
            $token = $user->createToken('customer_token', ['customer'])->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registrasi customer berhasil!',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
