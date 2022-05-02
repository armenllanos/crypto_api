<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\CoinDataSource\CoinDataSource;
use App\Infrastructure\Controllers\GetCoinController;
use Tests\TestCase;


class CoinStatusControllerTest extends TestCase
{
    private CoinDataSource $coinDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->coinDataSource = new CoinDataSource();
        $this->app->bind(CoinDataSource::class, fn () => $this->coinDataSource);
    }

    /**
     * @test
     */
    public function getBitcoinStatusFromApiTest()
    {

        $response = $this->get('/api/coin/status/90');
        $this->assertEquals("BTC",$response['symbol']);
    }
}
