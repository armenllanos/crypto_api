<?php

namespace App\Infrastructure\Controllers;

<<<<<<< HEAD

=======
>>>>>>> master
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
<<<<<<< HEAD
            $walletBalance=$this->getWalletBalanceService->execute($walletId);
        } catch (Exception $exception) {
            if ($exception->getMessage() === 'Wallet not found')
                return response()->json([
                    "error"=>"a wallet with the specified ID was not found"
=======
            $walletBalance = $this->getWalletBalanceService->execute($walletId);
        }catch (Exception $exception) {
            if ($exception->getMessage() === 'Wallet not found')
                return response()->json([
                    "error" => "a wallet with the specified ID was not found"
>>>>>>> master
                ], Response::HTTP_NOT_FOUND);

            else if ($exception->getMessage() === 'Service unavailable')
                return response()->json([
<<<<<<< HEAD
                    "error"=>"service is unavailable"
=======
                    "error" => "service is unavailable"
>>>>>>> master
                ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
        return response()->json([
            "balance_usd" => $walletBalance
        ],Response::HTTP_OK);
    }
}
