<?php

namespace Tests\app\Application\Coin;

use \App\Application\CoinDataSource\CoinDataSource;
use PHPUnit\Framework\TestCase;

class CoinDataSourceTest extends TestCase
{
    private CoinDataSource $coinDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->coinDataSource = new CoinDataSource();
    }


    /**
     * @test
     */
    public function getBitcoinTest()
    {

        $coinId = '90';

        $response = $this->coinDataSource->getCoin($coinId);

        $this->assertEquals('BTC',$response->getSymbol());
    }
}
