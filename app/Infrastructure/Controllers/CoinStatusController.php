<?php

namespace App\Infrastructure\Controllers;


<<<<<<< HEAD
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
=======
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
>>>>>>> master

    /**
     * @param CoinStatusService $coinStatusService
     */
<<<<<<< HEAD

=======
>>>>>>> master
    public function __construct(CoinStatusService $coinStatusService)
    {
        $this->coinStatusService = $coinStatusService;
    }

<<<<<<< HEAD

    public function __invoke(string $id_coin): JsonResponse
    {
        try {
            $coin = $this->coinStatusService->execute($id_coin);

=======
    public function __invoke(string $coinId): JsonResponse
    {
        try {
            $coin = $this->coinStatusService->execute($coinId);
>>>>>>> master
            if(is_null($coin))
                return response()->json(['error' => 'A coin with the specified ID was not found'], Response::HTTP_BAD_REQUEST);
            return response()->json(['coin_id' => $coin->getId(), 'symbol' => $coin->getSymbol(), 'name' => $coin->getName()
                , 'nameid' => $coin->getNameId(), 'rank' => $coin->getRank(), 'price_usd' => $coin->getPriceUSD()], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json(['error' => "Service unavailable"], Response::HTTP_SERVICE_UNAVAILABLE);
        }
<<<<<<< HEAD

        return response()->json(['coin_id' => $coin->getId(), 'symbol' => $coin->getSymbol(), 'name' => $coin->getName()
            , 'nameid' => $coin->getNameId(), 'rank' => $coin->getRank(), 'price_usd' => $coin->getPriceUSD()], Response::HTTP_OK);

=======
>>>>>>> master
    }

}
