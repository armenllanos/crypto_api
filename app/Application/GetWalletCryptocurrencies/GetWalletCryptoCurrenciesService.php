<?php
namespace App\Application\GetWalletCryptocurrencies;
use App\Application\WalletDataSource\WalletDataSource;

class GetWalletCryptoCurrenciesService
{
    /**
     * @var WalletDataSource
     */
    private  WalletDataSource $walletDataSource;

    /**
     * GetWalletService constructor.
     */
    public function __construct(WalletDataSource $walletDataSource){
        $this->walletDataSource = $walletDataSource;
    }

    public function execute(string $wallet_id)
    {
        $wallet = $this->walletDataSource->getWallet($wallet_id);
        if(is_null($wallet))
            return null;
        else
            return $wallet->getCoins();
    }
}
