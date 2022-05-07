<?php
namespace App\Application\WalletCreate;


use App\Application\WalletDataSource\WalletDataSource;
use App\Application\WalletId\IdGenerator;
use App\Application\WalletId\WalletIdGenerator;
use App\Domain\Wallet;
use Illuminate\Support\Str;
use mysql_xdevapi\Warning;


class WalletCreateService
{

    private WalletIdGenerator $walletIdGenerator;
    private WalletDataSource $walletDataSource;
    public function __construct(WalletIdGenerator $walletGenerator)
    {
        $this->walletIdGenerator = $walletGenerator;
        $this->walletDataSource = new WalletDataSource();
    }
    public function execute(): Wallet
    {
        $wallet_id = $this->walletIdGenerator->generateId();
        $wallet = new Wallet();
        $wallet->setWalletId($wallet_id);
        $this->walletDataSource->saveWallet($wallet);
        return $wallet;
    }
}
