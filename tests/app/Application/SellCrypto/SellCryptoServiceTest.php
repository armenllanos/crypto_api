<?php

namespace Tests\app\Application\SellCrypto;

use App\Application\CoinDataSource\CoinDataSource;
use App\Application\SellCrypto\SellCryptoService;
use App\Domain\Coin;
use Exception;
use Mockery;

class SellCryptoServiceTest extends \PHPUnit\Framework\TestCase
{
    private SellCryptoService $sellCryptoService;
    private CoinDataSource $coinDataSource;
    private \App\Application\WalletDataSource\WalletDataSource $walletDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->coinDataSource = Mockery::mock(CoinDataSource::class);
        $this->walletDataSource = Mockery::mock(\App\Application\WalletDataSource\WalletDataSource::class);
        $this->sellCryptoService = new SellCryptoService($this->coinDataSource, $this->walletDataSource);
    }

    /**
     * @test
     */
    public function coinNotFound()
    {

        $this->coinDataSource
            ->expects('getCoin')
            ->with('1234')
            ->andReturn( new Coin('random', '0','0', '0', '10', 0));
        $this->walletDataSource
            ->expects('getWallet')
            ->with('1234')
            ->andReturns(new \App\Domain\Wallet());

        $this->expectException(Exception::class);
        $response = $this->sellCryptoService->execute('1234','1234',0);

    }
    /**
     * @test
     */
    public function walletSubTest()
    {
        $wallet = new \App\Domain\Wallet();
        $coin = new Coin('0', '0','0', '0', '10', 1);
        $coin->setId('0');
        $coin->setPriceUSD('20');
        $coin->setAmount(1);
        $wallet->setCoins(array($coin->getId()=>$coin));
        $this->coinDataSource
            ->expects('getCoin')
            ->with('0')
            ->andReturn($coin);
        $this->walletDataSource
            ->expects('getWallet')
            ->with('1234')
            ->andReturns($wallet);
        $response = $this->sellCryptoService->execute('1234','0','10');
        $this->assertEquals($response[$coin->getId()]->getAmount(),0.5);

    }
}


