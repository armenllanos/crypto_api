<?php
namespace App\Application\WalletCreate;

use App\Application\WalletId\WalletIdGenerator;
use App\Domain\Wallet;
use Illuminate\Support\Str;
use mysql_xdevapi\Warning;


class WalletCreateService
{
    private WalletIdGenerator $walletIdGenerator;
    public function __construct(WalletIdGenerator $walletGenerator)
    {
        $this->walletIdGenerator = $walletGenerator;
    }
    public function execute(): Wallet
    {
        $wallet_id = $this->walletIdGenerator->generateId();
        $wallet = new Wallet();
        $wallet->setWalletId($wallet_id);
        return $wallet;
    }
}
