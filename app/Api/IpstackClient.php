<?php 

namespace App\Api;

use Exception;

class IpstackClient {

    public const ACCESS_KEY = 'b523d1999310c5b6783e0b6727beb3bc';

    public array $result;

    public function __construct(public string $ip)
    {
        
    }

    public function execute(): self
    {
        try {
            $ch = curl_init('http://api.ipstack.com/'.$this->ip.'?access_key='. self::ACCESS_KEY.'');
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