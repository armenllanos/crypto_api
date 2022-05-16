<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\CoinDataSource\CoinDataSource;
use App\Application\CoinStatus\CoinStatusService;
use App\Domain\Coin;
use App\Infrastructure\Controllers\CoinStatusController;
use App\Infrastructure\Controllers\GetCoinController;
use Tests\TestCase;


class CoinStatusControllerTest extends TestCase
{
    private CoinDataSource $coinDataSource;
    private CoinStatusService $coinStatusService;
    private CoinStatusController  $coinStatusController;

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
       // $response->assertExactJson(['asdad']);
        $this->assertEquals("BTC",$response['symbol']);
    }
}
