<?php 

namespace App\Service\IpClient;

use Exception;
use App\Contracts\IpClient;
use Core\Contracts\Support\Searchable;

class IpstackClient implements IpClient
{
    public const ACCESS_KEY = 'b523d1999310c5b6783e0b6727beb3bc';

    public array $result;

    public string $ipAdrees;

    public function search(string $ipAdrees = '')
    {
        $this->ipAdrees = $ipAdrees;

        $this->execute();

        return $this;
    }

    public function execute(): self
    {
        try {
            $ch = curl_init('http://api.ipstack.com/'.$this->ipAdrees.'?access_key='. self::ACCESS_KEY.'');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
                echo $e;
        }
        $this->result = (array) json_decode($result);

        return $this;
    }

    public function getContinentCode(): string
    {
        return $this->result['continent_code'];
    }

    public function getContinentName(): string
    {
        return $this->result['continent_name'];
    }

    public function getCountryCode(): string
    {
        return $this->result['country_code'];
    }

    public function getContryName(): string
    {
        return $this->result['country_name'];
    }
}