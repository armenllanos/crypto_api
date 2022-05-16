<?php
namespace App\Application\CoinStatus;

use App\Domain\Coin;
use App\Application\CoinDataSource\CoinDataSource;

<<<<<<< HEAD

class CoinStatusService implements CoinDataSource
=======
class CoinStatusService
>>>>>>> master
{
    /**
     * @var CoinDataSource
     */
    private $coinDataSource;

    /**
     * @param CoinDataSource $coinDataSource
     */
    public function __construct(CoinDataSource $coinDataSource)
    {
        $this->coinDataSource = $coinDataSource;
    }


    public function execute(string $idCoin) : ?Coin
    {
<<<<<<< HEAD

        return $this->coinDataSource->getCoinStatus($idCoin);
    }

    public function getCoinStatus(string $idCoin) : Coin
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.coinlore.net/api/ticker/?id=" . $idCoin,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"));
        $response = curl_exec($curl);
        $currency_data = json_decode($response, true);
        return new Coin($currency_data[0]['id'], $currency_data[0]['symbol'], $currency_data[0]['name'], $currency_data[0]['nameid'],
            $currency_data[0]['price_usd'], $currency_data[0]['rank']);
=======
       return $this->coinDataSource->getCoinStatus($idCoin);
>>>>>>> master
    }
}
