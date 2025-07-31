<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class ApiCustomerAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:customers',
            'password' => 'required',
        ]);

        $customer = Customer::where('nik', $request->nik)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'The provided credential are incorrect'], 401);
        }

        $token = $customer->createToken('customer-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'customer' => $customer,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'You are logged out']);
    }
}

