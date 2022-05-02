<?php
namespace App\Application\CoinStatus;

use App\Domain\Coin;
use App\Application\CoinDataSource\CoinDataSource;

class CoinStatusService
{
    /**
     * @var CoinDataSource
     */
    private $coinDataSource;

    /**
     * @param CoinDataSource $coinDataSource
     */
    public function __construct(CoinDataSource $coinDataSource)
    {
        $this->coinDataSource = $coinDataSource;
    }


    public function execute(string $idCoin) : Coin
    {
       return $this->coinDataSource->getCoinStatus($idCoin);
    }
}
