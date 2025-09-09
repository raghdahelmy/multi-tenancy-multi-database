<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Tenant;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegistrationForm extends Controller
{

            use ApiResponse;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //

         $data = $request->validate([
            'name' => 'required|string|max:255',
            'tenant' => ['required', 'string', 'max:255', 'unique:tenants,MerchantName'],
            'phone' => ['required'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $tenant = Tenant::create([
            // 'tenancy_db_name' =>'MarchantName_'. $data['tenant'],
            'id' =>$data['tenant'],
            'MerchantName' => $data['tenant'],
            'PhoneNumber' => $data['phone'],
            'user_id' => $user->id,
        ]);

        $tenant->domains()->create([
            'domain' => $data['tenant'],
        ]);


        return response()->json([
            'message' => 'تم تسجيل المستخدم بنجاح',
            'access_token' => $token,
            'user' => $user
        ], 201);
    }
}
