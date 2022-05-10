<?php

namespace App\Domain;

use Exception;
use function PHPUnit\Framework\throwException;

class Wallet
{
    private String $wallet_id;
    private array $coins = array();

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
    public function subCoin(Coin $coin, string $amount){
        $key = $coin->getId();
        if (array_key_exists($key, $this->coins)){
            echo '2';
            $this->coins[$key]->getAmount();
            $this->coins[$key]->setAmount($this->coins[$key]->getAmount()-$amount);

        }else{
            echo '3';
            throw new Exception('a coin with the specified ID was not found.');
        }
    }
}
