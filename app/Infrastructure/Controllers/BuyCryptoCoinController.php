<?php

namespace App\Infrastructure\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class BuyCryptoCoinController extends BaseController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
           'error' => 'service unavailable'
        ], Response::HTTP_SERVICE_UNAVAILABLE);
    }
}
