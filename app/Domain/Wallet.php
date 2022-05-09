<?php

namespace App\Domain;

class Wallet
{
    private String $wallet_id;
    private array $coins;

    /**
     * @return String
     */
    public function getWalletId(): string
    {
        return $this->wallet_id;
    }

    /**
     * @param String $wallet_id
     */
    public function setWalletId(string $wallet_id): void
    {
        $this->wallet_id=$wallet_id;
    }

    /**
     * @return array
     */
    public function getCoins(): array
    {
        return $this->coins;
    }

    /**
     * @param array $coins
     */
    public function setCoins(array $coins): void
    {
        $this->coins=$coins;
    }


}
