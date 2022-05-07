<?php

namespace App\Domain;

class Coin
{

    private string $id;
    private string $symbol;
    private string $name;
    private string $nameId;
    private string $priceUSD;
    private int $rank;
    private float $amount = 0;

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount=$amount;
    }

    /**
     * @param string $id
     * @param string $symbol
     * @param string $name
     * @param string $nameId
     * @param string $priceUSD
     * @param string $rank
     */
    public function __construct(string $id, string $symbol, string $name, string $nameId, string $priceUSD, int $rank)
    {
        $this->id = $id;
        $this->symbol = $symbol;
        $this->name = $name;
        $this->nameId = $nameId;
        $this->priceUSD = $priceUSD;
        $this->rank = $rank;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     */
    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getNameId(): string
    {
        return $this->nameId;
    }

    /**
     * @param string $nameId
     */
    public function setNameId(string $nameId): void
    {
        $this->nameId = $nameId;
    }

    /**
     * @return string
     */
    public function getPriceUSD(): string
    {
        return $this->priceUSD;
    }

    /**
     * @param string $priceUSD
     */
    public function setPriceUSD(string $priceUSD): void
    {
        $this->priceUSD = $priceUSD;
    }

    /**
     * @return string
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @param string $rank
     */
    public function setRank(int $rank): void
    {
        $this->rank = $rank;
    }



}
