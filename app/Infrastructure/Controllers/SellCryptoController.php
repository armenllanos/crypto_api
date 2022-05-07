<?php

namespace App\Infrastructure\Controllers;

use App\Application\SellCrypto\SellCryptoService;
use Barryvdh\Debugbar\Controllers\BaseController;
use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class SellCryptoController extends BaseController
{
    private SellCryptoService $sellCryptoCoinService;
    private $rules = [
        'wallet_id' => 'required',
        'coin_id' => 'required',
        "amount_usd" => 'required'
    ];
    private $messages = [
        'wallet_id.required' => 'wallet_id mandatory',
        'coin_id.required' => 'coin_id mandatory',
        'amount_usd.required' => 'amount_usd mandatory',
    ];
    private $errors;

    public function __construct(SellCryptoService $sellCryptoCoinService)
    {
        $this->sellCryptoCoinService = $sellCryptoCoinService;
    }
    public function __invoke(Request $request, SellCryptoService $buyCryptoCoinService): JsonResponse
    {
        try{
            $validator = Validator::make($request->all(), $this->rules, $this->messages);
            if ($validator->fails()) {
                $this->errors = $validator->errors()->first();
                $validator->validate();
            }
            $validatedData = $validator->validate();

            $response = $this->sellCryptoCoinService->execute($validatedData);
        }catch(Exception $exception){
            if ($exception->getMessage() === 'Service Unavailable'){
                return response()->json([
                    'error' => 'service unavailable'
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            }
        }
        return response()->json([
            'description' => 'succesful operation'
        ],Response::HTTP_OK);
    }

}
