<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GetWalletBalanceController
{
    public function __invoke(string $walletId): JsonResponse
    {
        return response()->json([
            "error" => "a wallet with the specified ID was not found"
        ], Response::HTTP_NOT_FOUND);
    }
}
