<?php

use App\Application\GetWalletCryptocurrencies\GetWalletCryptoCurrenciesService;
use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use PHPUnit\Framework\TestCase;

class GetWalletCryptocurrenciesServiceTest extends TestCase
{
    private WalletDataSource $walletDataSource;
    private GetWalletCryptocurrenciesService $getWalletCryptocurrenciesService;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->walletDataSource = Mockery::mock(WalletDataSource::class);

        $this->getWalletCryptocurrenciesService = new GetWalletCryptoCurrenciesService($this->walletDataSource);
    }
    /**
     * @test
     */
    public function getNonExistingWalletTest()
    {
        $wallet_id = '141414';
        $this->walletDataSource
            ->expects('getWallet')
            ->with($wallet_id)
            ->once()
            ->andReturn(null);

        $response = $this->getWalletCryptocurrenciesService->execute($wallet_id);

        $this->assertEquals(null, $response);
    }
    /**
     * @test
     */
    public function getWalletWithSpecificCoins(){
        $wallet_id = '1';
        $wallet = new Wallet();
        $wallet->setWalletId($wallet_id);
        $FirstCoin = new Coin("id","BTC","name","nameid","price_usd",1);
        $SecondCoin = new Coin("id2","AAA","name2","nameid2","price_usd",1);
        $ThirdCoin = new Coin("id3","CCC","name3","nameid3","price_usd",1);
        $wallet->setCoins([$FirstCoin,$SecondCoin,$ThirdCoin]);

        $this->walletDataSource
            ->expects('getWallet')
            ->with($wallet_id)
            ->once()
            ->andReturn($wallet);

        $response = $this->getWalletCryptocurrenciesService->execute($wallet_id);

        $this->assertEquals($wallet->getCoins(), $response);
    }
}
