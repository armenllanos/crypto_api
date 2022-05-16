<?php

namespace App\Infrastructure\Controllers;

use App\Application\GetWalletCryptocurrencies\GetWalletCryptoCurrenciesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Exception;

class GetWalletCryptocurrenciesController extends BaseController
{
    /**
     * @var GetWalletCryptoCurrenciesService
     */
    private GetWalletCryptoCurrenciesService $getWalletCryptoCurrenciesService;

    /**
     * @param GetWalletCryptoCurrenciesService $getWalletCryptoCurrenciesService
     */
    public function __construct(GetWalletCryptoCurrenciesService $getWalletCryptoCurrenciesService)
    {
        $this->getWalletCryptoCurrenciesService = $getWalletCryptoCurrenciesService;
    }

    public function __invoke(string $wallet_id): JsonResponse
    {
        try {
            $coins = $this->getWalletCryptoCurrenciesService->execute($wallet_id);
        }catch (Exception $exception) {
            if ($exception->getMessage() === 'Wallet not found')
                return response()->json([
                    "error" => "a wallet with the specified ID was not found"
                ], Response::HTTP_NOT_FOUND);

            else if ($exception->getMessage() === 'Service Unavailable')
                return response()->json([
                    "error" => "service is unavailable"
                ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
        return response()->json([
            "coins_array" => json_encode($coins)
        ],Response::HTTP_OK);
    }
}
