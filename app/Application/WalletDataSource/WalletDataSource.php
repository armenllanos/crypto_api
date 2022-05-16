<?php

namespace App\Application\WalletDataSource;
use App\Domain\Wallet;
use Illuminate\Support\Facades\Cache;


class WalletDataSource
{
  public function getWallet(string $walletId): ?Wallet
    {
        if (!Cache::has($walletId)) {
            return Exception("Wallet not found");
        } else {
            return Cache::get($walletId);
        }
    }

    public function saveWallet(Wallet $wallet)
    {
        Cache::put($wallet->getWalletId(), $wallet);
    }

    public function deleteWallet(string $walletId)
    {
        Cache::pull($walletId);
    }
}
