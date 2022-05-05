<?php

namespace App\Infrastructure\Controllers;

use App\Application\BuyCryptoCoin\BuyCryptoCoinService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Validator;

class BuyCryptoCoinController extends BaseController
{
    private BuyCryptoCoinService $buyCryptoCoinService;
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

    public function __construct(BuyCryptoCoinService $buyCryptoCoinService)
    {
        $this->buyCryptoCoinService = $buyCryptoCoinService;
    }
    public function __invoke(Request $request, BuyCryptoCoinService $buyCryptoCoinService): JsonResponse
    {
        try{
            $validator = Validator::make($request->all(), $this->rules, $this->messages);
            if ($validator->fails()) {
                $this->errors = $validator->errors()->first();
                $validator->validate();
            }
            $validatedData = $validator->validate();

            $response = $this->buyCryptoCoinService->execute($validatedData);
        }catch(Exception $exception){
            if ($exception->getMessage() === 'Service Unavailable')
                return response()->json([
                    'error' => 'service unavailable'
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            else if ($exception->getMessage() === 'The given data was invalid.')
                return response()->json([
                    'error' => $this->errors
                ], Response::HTTP_BAD_REQUEST);
            else if ($exception->getMessage() === 'Coin Not Found')
                return response()->json([
                    'error' => 'a coin with the specified ID was not found.'
                ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
        ],Response::HTTP_OK);
    }
}
