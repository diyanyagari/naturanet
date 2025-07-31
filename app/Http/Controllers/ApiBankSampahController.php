<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BankSampah;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiBankSampahController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = BankSampah::all();

        return response()->json([
            'token' => $request->bearerToken(),
            'data'  => $items,
        ], 200);
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $item = BankSampah::findOrFail($id);

        return response()->json([
            'token' => $request->bearerToken(),
            'data'  => $item,
        ], 200);
    }
}
