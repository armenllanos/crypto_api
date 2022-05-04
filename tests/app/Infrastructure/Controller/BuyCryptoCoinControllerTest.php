<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\CoinDataSource\CoinDataSource;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class BuyCryptoCoinControllerTest extends TestCase
{
    private CoinDataSource $coinDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->coinDataSource = Mockery::mock(CoinDataSource::class);

        $this->app->bind(CoinDataSource::class, fn () => $this->coinDataSource);
    }

    /**
     * @test
     */
    public function genericServiceUnavailableErrorWhenBuyingCoin()
    {
        $response = $this->post('api/coin/buy');

        $response->assertStatus(Response::HTTP_SERVICE_UNAVAILABLE)
            ->assertExactJson(['error' => 'service unavailable']);
    }
}

