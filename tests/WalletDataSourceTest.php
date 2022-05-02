<?php

namespace Tests;

use App\Application\CoinDataSource\CoinDataSource;
use App\Application\WalletDataSource\WalletDataSource;
use App\Domain\Wallet;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\TestCase;

class WalletDataSourceTest extends TestCase
{

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
    }
    /**
     * @test
     */
    public function getWalletTest()
    {
        $wallet = new Wallet();
        $wallet->setWalletId('1234');
        $walletData = new WalletDataSource();
        Cache::shouldReceive('has')
            ->with('1234')
            ->andReturn(true);
        Cache::shouldReceive('get')
            ->with('1234')
            ->andReturn($wallet);
        $response = $walletData->getWallet($wallet->getWalletId());
        $this->assertEquals($wallet,$response);
    }

}
