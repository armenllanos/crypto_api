<?php


use App\Application\CoinDataSource\CoinDataSource;
use App\Application\SellCrypto\SellCryptoService;
use App\Domain\Coin;

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
            ->andReturn(null);
        $this->walletDataSource
            ->expects('getWallet')
            ->with('1234')
            ->andReturns(new \App\Domain\Wallet());


        $response = $this->sellCryptoService->execute('1234','1234',0);
        $this->assertNull($response);

    }

}
