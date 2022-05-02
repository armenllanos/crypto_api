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
    public function execute(string $walletId): string
    {
        $walletBalance = $this->walletDataSource->getWallet($walletId);

        return $walletBalance;
    }
}
