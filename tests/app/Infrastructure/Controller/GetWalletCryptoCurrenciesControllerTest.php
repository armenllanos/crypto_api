<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class GetWalletCryptoCurrenciesControllerTest extends TestCase
{
    private WalletDataSource $walletDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->walletDataSource = Mockery::mock(WalletDataSource::class);

        $this->app->bind(WalletDataSource::class, fn () => $this->walletDataSource);
    }

    /**
     * @test
     */
    public function serviceUnavailableWhenGettingWallet()
    {
        $this->walletDataSource
            ->expects("getWallet")
            ->with('1414')
            ->once()
            ->andThrow(new Exception('Service Unavailable'));

        $response = $this->get('api/wallet/1414');
        $response->assertStatus(Response::HTTP_SERVICE_UNAVAILABLE)
            ->assertExactJson(['error' => 'service is unavailable']);
    }

    /**
     * @test
     */
    public function walletWithGivenIdNotFound()
    {
        $this->walletDataSource
            ->expects("getWallet")
            ->with('13')
            ->once()
            ->andThrow(new Exception('Wallet not found'));

        $response = $this->get('api/wallet/13');
        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertExactJson(['error' => 'a wallet with the specified ID was not found']);
    }

    /**
     * @test
     */
    public function SpecificCoinsArrayReceivedCorrectly()
    {
        $wallet = new Wallet();
        $FirstCoin = new Coin("id","BTC","name","nameid","price_usd",1);
        $SecondCoin = new Coin("id2","AAA","name2","nameid2","price_usd",1);
        $ThirdCoin = new Coin("id3","CCC","name3","nameid3","price_usd",1);
        $wallet->setCoins([$FirstCoin,$SecondCoin, $ThirdCoin]);

        $this->walletDataSource
            ->expects("getWallet")
            ->with('1')
            ->once()
            ->andReturn($wallet);

        $response = $this->get('api/wallet/1');
        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson(['coins_array' => json_encode($wallet->getCoins())]);
    }
}
