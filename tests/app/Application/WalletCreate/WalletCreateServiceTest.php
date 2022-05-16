<?php
namespace Tests\app\Application\WalletCreate;

use App\Application\WalletCreate\WalletCreateService;
use App\Application\WalletId\WalletIdGenerator;
use App\Domain\Wallet;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\TestCase;


class WalletCreateServiceTest extends TestCase
{
    private WalletCreateService $walletCreateService;
    private WalletIdGenerator $walletIdGenerator;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->walletIdGenerator = Mockery::mock(WalletIdGenerator::class);
        $this->walletCreateService = new  WalletCreateService($this->walletIdGenerator);
    }

    /**
     * @test
     */
    public function walletCreateTest()
    {
        $wallet = new Wallet();
        $wallet->setWalletId('1234');
        $this->walletIdGenerator
            ->expects('generateId')
            ->andReturn('1234');
        Cache::shouldReceive('put')
            ->withAnyArgs();
        $newWallet = $this->walletCreateService->execute();
        $this->assertEquals($newWallet->getWalletId(),$wallet->getWalletId());
    }


}
