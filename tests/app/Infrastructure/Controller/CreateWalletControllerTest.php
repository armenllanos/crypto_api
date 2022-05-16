<?php

namespace Tests\app\Infrastructure\Controller;



use App\Application\WalletDataSource\WalletDataSource;
use App\Application\WalletId\WalletIdGenerator;
use App\Domain\Wallet;
use Exception;
use Mockery;
use Tests\TestCase;

class CreateWalletControllerTest extends TestCase
{
    private WalletDataSource $walletDataSource;
    private WalletIdGenerator $walletIdGenerator;
    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->walletIdGenerator = Mockery::mock(WalletIdGenerator::class);
        $this->app->bind(WalletIdGenerator::class, fn () => $this->walletIdGenerator);
        $this->app->bind(WalletDataSource::class, fn () => $this->walletDataSource);
    }
    /**
     * @test
     */
    public function controllerCreateWalletTest()
    {
        $wallet = new Wallet();
        $wallet->setWalletId('1234');
        $this->walletIdGenerator
            ->expects('generateId')
            ->andReturn('1234');
        $response=$this->json('POST','/api/wallet/open');
        $response->assertExactJson(['wallet_id' => '1234']);
    }
    /**
     * @test
     */
    public function controllerErrorCreateWalletTest()
    {
        $wallet = new Wallet();
        $wallet->setWalletId('1234');
        $this->walletIdGenerator
            ->expects('generateId')
            ->andThrow(new Exception('Service unavailable'));
        $response = $this->post('api/wallet/open');
        $response->assertExactJson(['error' => 'Service unavailable']);
    }
}
