<?php

namespace App\Infrastructure\Controllers;

use App\Application\CoinDataSource\CoinDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use PHPUnit\Util\Exception;

class GetCoinController extends BaseController
{

    /**
     * @var CoinDataSource
     */
    private $coinStatusService;

    /**
     * @param $coinStatusService
     */
    public function __construct($coinStatusService)
    {
        $this->coinStatusService = $coinStatusService;
    }

    public function __invoke(string $id_coin): JsonResponse
    {
        try {
            $coin = $this->coinStatusService->execute($id_coin);

            if(is_null($coin))
                return response()->json(['error' => 'A coin with the specified ID was not found'], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_SERVICE_UNAVAILABLE);
        }


        return response()->json(['coin_id' => $coin->getId(), 'symbol' => $coin->getEmail(), 'name' => $coin->getEmail()
            , 'nameid' => $coin->getEmail(), 'rank' => $coin->getEmail(), 'price_usd' => $coin->getEmail()], Response::HTTP_OK);

    }

}
