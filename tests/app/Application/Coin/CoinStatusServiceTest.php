<?php

namespace Tests\app\Application\Coin;

use App\Application\CoinDataSource\CoinDataSource;
use App\Application\CoinStatus\CoinStatusService;
use App\Domain\Coin;
use PHPUnit\Framework\TestCase;
use Exception;
use Mockery;

class CoinStatusServiceTest extends TestCase
{
    private CoinDataSource $coinDataSource;
    private CoinStatusService $coinStatusService;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->coinDataSource = Mockery::mock(CoinDataSource::class);

        $this->coinStatusService = new CoinStatusService($this->coinDataSource);

    }


    /**
     * @test
     */
    public function getBitcoinTest()
    {

        $coinId = '90';

        $coin = new Coin("id","BTC","name","nameid","price_usd",1);
        $this->coinDataSource
            ->expects('getCoinStatus')
            ->with($coinId)
            ->once()
            ->andReturn($coin);

        $response = $this->coinStatusService->execute($coinId);

        $this->assertEquals("BTC",$response->getSymbol());

    }
}
