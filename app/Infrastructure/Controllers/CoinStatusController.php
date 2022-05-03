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
     * @param CoinStatusService $coinStatusService
     */

    public function __construct(CoinStatusService $coinStatusService)
    {
        $this->coinStatusService = $coinStatusService;
    }


    public function __invoke(string $id_coin): JsonResponse
    {
        try {
            $coin = $this->coinStatusService->execute($id_coin);

            if(is_null($coin))
                return response()->json(['error' => 'A coin with the specified ID was not found'], Response::HTTP_BAD_REQUEST);
            return response()->json(['coin_id' => $coin->getId(), 'symbol' => $coin->getSymbol(), 'name' => $coin->getName()
                , 'nameid' => $coin->getNameId(), 'rank' => $coin->getRank(), 'price_usd' => $coin->getPriceUSD()], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json(['error' => "Service unavailable"], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        return response()->json(['coin_id' => $coin->getId(), 'symbol' => $coin->getSymbol(), 'name' => $coin->getName()
            , 'nameid' => $coin->getNameId(), 'rank' => $coin->getRank(), 'price_usd' => $coin->getPriceUSD()], Response::HTTP_OK);

    }

}
