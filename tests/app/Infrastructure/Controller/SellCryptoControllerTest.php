<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\CoinDataSource\CoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;
use Exception;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SellCryptoControllerTest extends TestCase
{
    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->coinDataSource = Mockery::mock(CoinDataSource::class);
        $this->walletDataSource = Mockery::mock(WalletDataSource::class);

        $this->app->bind(CoinDataSource::class, fn () => $this->coinDataSource);
        $this->app->bind(WalletDataSource::class, fn () => $this->walletDataSource);
    }

    /**
     * @test
     */
    public function serviceUnavailableErrorTest()
    {
        $coinPurchaseData = array(
            "coin_id" => "999",
            "wallet_id" => "999",
            "amount_usd"=> 0
        );
        $this->walletDataSource
            ->expects("getWallet")
            ->with($coinPurchaseData['wallet_id'])
            ->once()
            ->andThrow(new Exception('Service Unavailable'));
        $response = $this->post('api/coin/buy', $coinPurchaseData);
        $response->assertExactJson(['error' => 'service unavailable']);
    }



}
