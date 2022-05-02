<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\CoinStatus\CoinStatusService;
use App\Infrastructure\Controllers\CoinStatusController;
use PHPUnit\Framework\TestCase;
use Exception;
use Illuminate\Http\Response;
use Mockery;

class GetCoinControllerTest extends TestCase
{

    private CoinStatusController $coinStatusController;
    private CoinStatusService $coinStatusService;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->coinStatusService = new CoinStatusService();
        $this->coinStatusController = new CoinStatusController();
    }



}
