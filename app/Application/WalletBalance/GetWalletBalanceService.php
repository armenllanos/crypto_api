<?php

namespace App\Application\WalletBalance;

use App\Domain\Wallet;
use App\Application\WalletDataSource\WalletDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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

        foreach ($walletCoins as $quantity => $coin) {
            $walletBalance = $walletBalance + $coin->getPriceUSD() * $quantity;
        }

        return $walletBalance;
    }
}
