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
    public function balanceOfSpecificWalletIsZero()
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

        $response = $this->getWalletBalanceService->execute($walletId);

        $this->assertEquals($expectedWalletBalance, $response);
    }
    /**
     * @test
     */
    public function balanceOfSpecificWalletReturnsNonEmptyBalance()
    {
        $wallet = new Wallet();
        $walletId = '1';
        $wallet->setWalletId($walletId);

        $genericCoin =  new Coin('90', 'BTC', 'Bitcoin', 'bitcoin', '30', '1');
        $genericCoin2 =  new Coin('30', 'ETH', 'Ethereum', 'ethereum', '30', '2');
        $amount = 2;
        $coinArray = array($genericCoin->getSymbol() => array('coinInformation'=> $genericCoin, 'amount' => $amount),
            $genericCoin2->getSymbol() => array('coinInformation'=> $genericCoin2, 'amount' => $amount));

        $wallet->setCoins($coinArray);

        $this->walletDataSource
            ->expects("getWallet")
            ->with($walletId)
            ->once()
            ->andReturn($wallet);

        $expectedWalletBalance = $amount * $genericCoin->getPriceUSD() + $genericCoin2->getPriceUSD() * $amount;

        $response = $this->getWalletBalanceService->execute($walletId);

        $this->assertEquals($expectedWalletBalance, $response);
    }
}
