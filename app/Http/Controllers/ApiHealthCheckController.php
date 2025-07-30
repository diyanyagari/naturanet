<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class ApiHealthCheckController extends Controller
{
    public function show()
    {
        try {
            DB::connection()->getPdo();
            $db = 'UP';
            $code = 200;
        } catch (\Exception $e) {
            $db = 'DOWN';
            $code = 503;
        }

        return response()->json([
            'app'       => 'OK',
            'database'  => $db,
            'timestamp' => now()->toDateTimeString(),
        ], $code);
    }
}
