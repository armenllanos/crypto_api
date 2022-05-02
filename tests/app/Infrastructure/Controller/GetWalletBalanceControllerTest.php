<?php

namespace Tests\app\Infrastructure\Controller;
use Tests\TestCase;

class GetWalletBalanceControllerTest extends TestCase
{
    /**
     * @test
     */
    public function walletWithGivenIdDoesNotExist()
    {
        $response = $this->get('api/wallet/999/balance');
        $response->assertExactJson(['error' => 'a wallet with the specified ID was not found']);
    }
}
