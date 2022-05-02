<?php

namespace App\Infrastructure\Controllers;


use App\Application\CoinStatus\CoinStatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Exception;


class CoinStatusController extends BaseController
{

    /**
     * @var CoinStatusService
     */
    private CoinStatusService $coinStatusService;

    /**
     * @param $coinStatusService
     */
    public function __construct($coinStatusService)
    {
        $this->coinStatusService = $coinStatusService;
    }

    public function __invoke(string $coinId): JsonResponse
    {
        try {
            $coin = $this->coinStatusService->execute($coinId);
            if(is_null($coin))
                return response()->json(['error' => 'A coin with the specified ID was not found'], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        return response()->json(['coin_id' => $coin->getId(), 'symbol' => $coin->getSymbol(), 'name' => $coin->getName()
            , 'nameid' => $coin->getNameId(), 'rank' => $coin->getRank(), 'price_usd' => $coin->getPriceUSD()], Response::HTTP_OK);
    }

}
