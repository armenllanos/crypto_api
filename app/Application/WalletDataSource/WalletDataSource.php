<?php

namespace App\Application\WalletDataSource;
use App\Domain\Wallet;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Cache\Repository;


class WalletDataSource
{
  public function getWallet(string $walletId): ?Wallet
    {
        if (!Cache::has($walletId)) {
            return null;
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
