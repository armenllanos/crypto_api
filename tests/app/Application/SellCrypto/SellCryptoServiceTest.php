<?php

namespace Tests\app\Application\SellCrypto;

use App\Application\CoinDataSource\CoinDataSource;
use App\Application\SellCrypto\SellCryptoService;
use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Exception;
use Mockery;
use Tests\TestCase;

class SellCryptoServiceTest extends TestCase
{
    private SellCryptoService $sellCryptoService;
    private CoinDataSource $coinDataSource;
    private WalletDataSource $walletDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->coinDataSource = Mockery::mock(CoinDataSource::class);
        $this->walletDataSource = Mockery::mock(WalletDataSource::class);
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
            ->andReturns(new Wallet());

        $this->expectException(Exception::class);
        $response = $this->sellCryptoService->execute('1234','1234',0);

    }
    /**
     * @test
     */
    public function walletSubTest()
    {
        $wallet = new Wallet();
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


