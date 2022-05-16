<?php

namespace Tests\app\Application\Coin;

use App\Application\CoinDataSource\CoinDataSource;
use App\Application\CoinStatus\CoinStatusService;
use App\Domain\Coin;
use PHPUnit\Framework\TestCase;
use Exception;
use Mockery;

<<<<<<< HEAD

class CoinDataSourceTest extends TestCase

{
    private CoinDataSource $coinDataSource;
    private CoinStatusService $getCoinStatusService;
=======
class CoinStatusServiceTest extends TestCase
{
    private CoinDataSource $coinDataSource;
    private CoinStatusService $coinStatusService;
>>>>>>> master

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->coinDataSource = Mockery::mock(CoinDataSource::class);

<<<<<<< HEAD
        $this->getCoinStatusService = new CoinStatusService($this->coinDataSource);
=======
        $this->coinStatusService = new CoinStatusService($this->coinDataSource);

>>>>>>> master
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

<<<<<<< HEAD
        $response = $this->getCoinStatusService->getCoinStatus($coinId);
=======
        $response = $this->coinStatusService->execute($coinId);
>>>>>>> master

        $this->assertEquals("BTC",$response->getSymbol());

    }

    /**
     * @test
     */
    public function getNonExistingCoin()
    {
        $coinId = '54545454';
        $this->coinDataSource
            ->expects('getCoinStatus')
            ->with($coinId)
            ->once()
            ->andReturn(null);

        $response = $this->coinStatusService->execute($coinId);
        $this->assertEquals(null,$response);
    }
}
