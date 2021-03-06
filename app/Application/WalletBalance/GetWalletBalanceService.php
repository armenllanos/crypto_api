<?php

namespace App\Application\WalletBalance;


use App\Application\WalletDataSource\WalletDataSource;


class GetWalletBalanceService
{
    /**
     * @var WalletDataSource
     */
    private $walletDataSource;

    /**
     * GetWalletBalanceService constructor.
     * @param WalletDataSource WalletDataSource
     */
    public function __construct(WalletDataSource $walletDataSource){
        $this->walletDataSource = $walletDataSource;
    }
    public function execute(string $walletId)
    {
        $walletBalance = 0;
        $wallet = $this->walletDataSource->getWallet($walletId);
        $walletCoins = $wallet->getCoins();

        foreach ($walletCoins as $coin) {
            $walletBalance = $walletBalance + $coin['coinInformation']->getPriceUSD() * $coin['amount'];
        }

        return $walletBalance;
    }
}
