<?php

namespace Tests\app\Application\WalletBalance;

use App\Application\WalletBalance\GetWalletBalanceService;
use App\Application\WalletDataSource\WalletDataSource;
use Tests\TestCase;
use Exception;
use Mockery;
use App\Domain\Wallet;

class GetWalletBalanceServiceTest extends TestCase
{
    private GetWalletBalanceService $getWalletBalanceService;
    private WalletDataSource $walletDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->walletDataSource = Mockery::mock(WalletDataSource::class);

        $this->getWalletBalanceService = new GetWalletBalanceService($this->walletDataSource);
    }
    /**
     * @test
     */
    public function walletWithSpecificIdNotFound()
    {
        $walletId = '999';
        $this->walletDataSource
            ->expects("getWallet")
            ->with($walletId)
            ->once()
            ->andThrow(new Exception('Wallet not found'));

        $this->expectException(Exception::class);

        $this->getWalletBalanceService->execute($walletId);
    }

    /**
     * @test
     */
    public function balanceOfSpecificWalletIsEmpty()
    {
        $walletId = '0';
        $wallet = new Wallet();
        $wallet->setWalletId($walletId);
        $wallet->setCoins([]);
        $walletBalance = ["balance_usd" => '0'];

        $this->walletDataSource
            ->expects("getWallet")
            ->with($walletId)
            ->once()
            ->andReturn($wallet);

        $this->getWalletBalanceService->execute($walletId);
    }
}
