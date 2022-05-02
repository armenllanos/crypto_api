<?php

namespace App\Application\CoinDataSource;

use App\Domain\Coin;

interface CoinDataSource
{

    public function getCoinStatus(string $idCoin) : Coin;

}
