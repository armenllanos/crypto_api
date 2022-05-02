<?php

namespace App\Infrastructure\Controllers;

use App\Application\WalletBalance\GetWalletBalanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;

class GetWalletBalanceController
{
    private GetWalletBalanceService $getWalletBalanceService;
    public function __construct(GetWalletBalanceService $getWalletBalanceService)
    {
        $this->getWalletBalanceService = $getWalletBalanceService;
    }
    public function __invoke(string $walletId): JsonResponse
    {
        try {
            $walletBalance = $this->getWalletBalanceService->execute($walletId);
        }catch (Exception $exception) {
            if ($exception->getMessage() === 'Wallet not found')
                return response()->json([
                    "error" => "a wallet with the specified ID was not found"
                ], Response::HTTP_NOT_FOUND);
            else if ($exception->getMessage() === 'Service unavailable')
                return response()->json([
                    "error" => "service is unavailable"
                ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
        return [];
    }
}
