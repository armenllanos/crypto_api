<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\CoinDataSource\CoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Wallet;
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
        $response = $this->post('api/coin/sell', $coinPurchaseData);
        $response->assertExactJson(['error' => 'service unavailable']);
    }
    /**
     * @test
     */
    public function errorMissingParameterTest()
    {
        $coinPurchaseData = array(
            "coin_id" => "999",
            "wallet_id" => "999",
        );

        $response = $this->post('api/coin/sell', $coinPurchaseData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertExactJson(['error' => 'amount_usd mandatory']);
    }
    /**
     * @test
     */
    public function coinToSellDoesNotExistTest()
    {
        $wallet = new Wallet();
        $coinPurchaseData = array(
            "coin_id" => "999",
            "wallet_id" => "999",
            "amount_usd" => "0"
        );
        $this->walletDataSource
            ->expects("getWallet")
            ->andReturn($wallet);

        $this->coinDataSource
            ->expects("getCoin")
            ->with($coinPurchaseData['coin_id'])
            ->once()
            ->andThrow(new Exception('Coin Not Found'));

        $response = $this->post('api/coin/sell', $coinPurchaseData);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertExactJson(['error' => 'a coin with the specified ID was not found.']);
    }



}
