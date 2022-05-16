<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\CoinDataSource\CoinDataSource;
use Illuminate\Http\Response;
use Tests\TestCase;
use Mockery;
use Exception;


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
        print_r($response);
        $this->assertEquals("BTC",$response['symbol']);
    }

    /**
     * @test
     */
    public function getStatusOfNotExistingCoinId()
    {
        $response = $this->get('/api/coin/status/654654');
        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(["error"=>"A coin with the specified ID was not found"]);
    }

    /**
     * @test
     */
    public function serviceUnavailableTest()
    {
        $this->coinDataSource = Mockery::mock(CoinDataSource::class);
        $this->coinDataSource
            ->expects('getCoinStatus')
            ->withAnyArgs()
            ->once()
            ->andThrow(New Exception("Service unavailable",Response::HTTP_SERVICE_UNAVAILABLE));

        $response = $this->get('/api/coin/status/654654');
        $response->assertStatus(Response::HTTP_SERVICE_UNAVAILABLE)->assertExactJson(["error"=>"Service unavailable"]);
   }

}
