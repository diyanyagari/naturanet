<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiGetCustomerProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'customer' => $request->user(),
        ]);
    }
}