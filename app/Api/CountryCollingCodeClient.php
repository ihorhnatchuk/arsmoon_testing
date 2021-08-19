<?php 

namespace App\Api;

use Exception;

class CountryCollingCodeClient {

    public array $result;

    public function __construct()
    {
        
    }

    public function execute(): self
    {
        try {
            $result = file_get_contents( dirname(dirname( __DIR__)).'/storage/country-code.json');
        } catch (Exception $e) {
                echo $e;
        }
        $this->result = (array) json_decode($result);

        return $this;
    }

    public function getResult(): array
    {
        return $this->result;
    }
}