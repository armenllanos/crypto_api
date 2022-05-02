<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\WalletDataSource\WalletDataSource;
use Exception;
use Mockery;
use Tests\TestCase;

class GetWalletBalanceControllerTest extends TestCase
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
    public function walletWithGivenIdDoesNotExist()
    {
        $this->walletDataSource
            ->expects("getWallet")
            ->with('999')
            ->once()
            ->andThrow(new Exception('Wallet not found'));

        $response = $this->get('api/wallet/999/balance');

        $response->assertExactJson(['error' => 'a wallet with the specified ID was not found']);
    }

    /**
     * @test
     */
    public function genericServiceUnavailableErrorWhenGettingWalletBalance()
    {
        $this->walletDataSource
            ->expects("getWallet")
            ->with('999')
            ->once()
            ->andThrow(new Exception('Service unavailable'));

        $response = $this->get('api/wallet/999/balance');

        $response->assertExactJson(['error' => 'service is unavailable']);
    }
}
