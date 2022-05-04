<?php

namespace App\Infrastructure\Controllers;

use App\Application\BuyCryptoCoin\BuyCryptoCoinService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class BuyCryptoCoinController extends BaseController
{
    private BuyCryptoCoinService $buyCryptoCoinService;
    public function __construct(BuyCryptoCoinService $buyCryptoCoinService)
    {
        $this->buyCryptoCoinService = $buyCryptoCoinService;
    }
    public function __invoke(Request $request, BuyCryptoCoinService $buyCryptoCoinService): JsonResponse
    {
        try{
            $data = $request->validate([
                'wallet_id' => 'required',
                'coin_id' => 'required',
                'amount_usd' => 'required'
            ]);
            $response = $this->buyCryptoCoinService->execute($data);
        }catch(Exception $exception){
            print_r($exception->getMessage());
            if ($exception->getMessage() === 'Service Unavailable')
                return response()->json([
                    'error' => 'service unavailable'
                ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
        return response()->json([
            "balance_usd" => $walletBalance
        ],Response::HTTP_OK);
    }
}
