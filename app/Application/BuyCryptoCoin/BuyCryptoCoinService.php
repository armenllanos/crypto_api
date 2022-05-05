<?php

namespace App\Application\BuyCryptoCoin;

use App\Application\CoinDataSource\CoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;


class BuyCryptoCoinService
{
    /**
     * @var CoinDataSource
     * @var WalletDataSource
     */
    private $coinDataSource;
    private $walletDataSource;

    /**
     * BuyCryptoCoinService constructor.
     * @param CoinDataSource $coinDataSource
     * @param WalletDataSource $walletDataSource
     */
    public function __construct(CoinDataSource $coinDataSource, WalletDataSource $walletDataSource){
        $this->coinDataSource = $coinDataSource;
        $this->walletDataSource = $walletDataSource;
    }
    public function execute(array $requestInformation)
    {
        $wallet = $this->walletDataSource->getWallet($requestInformation['wallet_id']);
        if (isset($wallet))
            $coin = $this->coinDataSource->getCoin($requestInformation['coin_id']);
        return '';
    }
}
