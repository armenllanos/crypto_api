<?php

namespace App\Application\SellCrypto;


use App\Application\CoinDataSource\CoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;

class SellCryptoService
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
    public function execute(string $walletId, string $coinId, string $amountUsd)
    {
        $wallet = $this->walletDataSource->getWallet($walletId);
        $coin = $this->coinDataSource->getCoin($coinId);
        if($coin ==  null){
            return null;
        }
        $moneyToGet = $amountUsd;
        $coinAmount = $moneyToGet / $coin->getPriceUSD();
        $wallet->subCoin($coin, $coinAmount);
        return $wallet->getCoins();
    }

}
