<?php

namespace Tests\app\Application\BuyCryptoCoin;

use Tests\TestCase;
use App\Application\BuyCryptoCoin\BuyCryptoCoinService;
use App\Application\WalletDataSource\WalletDataSource;
use App\Application\CoinDataSource\CoinDataSource;
use App\Domain\Wallet;
use App\Domain\Coin;
use Mockery;

class BuyCryptoCoinServiceTest extends TestCase
{
    private BuyCryptoCoinService $buyCryptoCoinService;
    private WalletDataSource $walletDataSource;
    private CoinDataSource $coinDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->walletDataSource = Mockery::mock(WalletDataSource::class);
        $this->coinDataSource = Mockery::mock(CoinDataSource::class);
        $this->buyCryptoCoinService = new BuyCryptoCoinService($this->coinDataSource, $this->walletDataSource);
    }

    /**
     * @test
     */
    public function buysASpecificCoinWithASpecificAmountOfUSDAndItIsAddedToWallet()
    {
        $walletId = '999';
        $wallet = new Wallet($walletId);

        $genericCoin =  new Coin('1', 'BTC', 'Bitcoin', 'bitcoin', '30', '1');

        $requestInformation = ['coin_id' => '1', 'wallet_id' => $walletId, 'amount_usd' => '30'];

        $this->walletDataSource
            ->expects("getWallet")
            ->with($walletId)
            ->once()
            ->andReturn($wallet);

        $this->coinDataSource
            ->expects("getCoin")
            ->once()
            ->andReturn($genericCoin);
        $response = $this->buyCryptoCoinService->execute($requestInformation);

        $expectedResponse = ['BTC' => array('coinInformation' => $genericCoin, 'amount' => '1')];

        $this->assertEquals($expectedResponse, $response);
    }
    /**
     * @test
     */
    public function buysASpecificCoinWithASpecificAmountOfUSDThatGivesHalfACoin()
    {
        $walletId = '999';
        $wallet = new Wallet($walletId);

        $genericCoin =  new Coin('1', 'BTC', 'Bitcoin', 'bitcoin', '30', '1');

        $requestInformation = ['coin_id' => '1', 'wallet_id' => $walletId, 'amount_usd' => '15'];

        $this->walletDataSource
            ->expects("getWallet")
            ->with($walletId)
            ->once()
            ->andReturn($wallet);

        $this->coinDataSource
            ->expects("getCoin")
            ->once()
            ->andReturn($genericCoin);
        $response = $this->buyCryptoCoinService->execute($requestInformation);

        $expectedResponse = ['BTC' => array('coinInformation' => $genericCoin, 'amount' => '0.5')];

        $this->assertEquals($expectedResponse, $response);
    }
}
