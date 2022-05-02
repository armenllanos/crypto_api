<?php

namespace App\Application\WalletBalance;

use App\Domain\Wallet;
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
    public function execute(string $walletId): array
    {
        $walletBalance = 0;
        $wallet = $this->walletDataSource->getWallet($walletId);
        $walletCoins = $wallet->getCoins();

        if (empty($walletCoins)){
            return ['balance_usd' => '0'];
        }

        foreach ($walletCoins as $coin) {
            $walletBalance = $walletBalance + $coin->getPriceUSD();
        }

        return $walletBalance;
    }
}
