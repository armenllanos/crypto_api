<?php

namespace App\Domain;

class Wallet
{
    private String $wallet_id;
    private array $coins = [];
    public function __construct(string $wallet_id){
        $this->wallet_id = $wallet_id;
    }
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

    public function addCoin(Coin $coin, string $amount){
        $key = $coin->getSymbol();
        if (array_key_exists($key, $this->coins)){
            $this->coins[$key]['amount'] += $amount;
        }
        else {
            $this->coins[$key] = array('coinInformation' => $coin, 'amount' => $amount);
        }
    }

}
