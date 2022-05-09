<?php

namespace App\Infrastructure\Controllers;

use App\Application\WalletCreate\WalletCreateService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class CreateWalletController extends BaseController
{
    private $walletCreateService;

    /**
     * IsEarlyAdopterUserController constructor.
     */
    public function __construct(WalletCreateService $walletCreateService)
    {
        $this->walletCreateService = $walletCreateService;
    }

    public function __invoke(): JsonResponse
    {
        try {
            $wallet = $this->walletCreateService->execute();
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()

            ], Response::HTTP_SERVICE_UNAVAILABLE);

        }

        return response()->json([
            'wallet_id' => $wallet->getWalletId()
        ], Response::HTTP_OK);
    }
}
