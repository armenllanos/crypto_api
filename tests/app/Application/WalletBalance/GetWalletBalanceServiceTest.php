<?php

namespace Tests\app\Application\WalletBalance;

use App\Application\WalletBalance\GetWalletBalanceService;
use App\Application\WalletDataSource\WalletDataSource;
use Tests\TestCase;
use Exception;
use Mockery;
use App\Domain\Coin;
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

        $this->walletDataSource
            ->expects("getWallet")
            ->with($walletId)
            ->once()
            ->andReturn($wallet);

        $expectedWalletBalance = 0;
        $expectedResponse = json_encode(['balance_usd' => $expectedWalletBalance]);

        $response = $this->getWalletBalanceService->execute($walletId);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function balanceOfSpecificWalletReturnsNonEmptyBalance()
    {
        $wallet = new Wallet();
        $walletId = '1';
        $wallet->setWalletId($walletId);

        $coinBTC =  new Coin('90', 'BTC', 'Bitcoin', 'bitcoin', '30', '1');
        $amount = 2;
        $wallet->setCoins([$amount => $coinBTC]);

        $this->walletDataSource
            ->expects("getWallet")
            ->with($walletId)
            ->once()
            ->andReturn($wallet);

        $expectedWalletBalance = $amount * $coinBTC->getPriceUSD();
        $expectedResponse = json_encode(['balance_usd' => $expectedWalletBalance]);

        $response = $this->getWalletBalanceService->execute($walletId);

        $this->assertEquals($expectedResponse, $response);
    }
}
