<?php 

namespace App\Service\PhoneClient;

use App\Contracts\PhoneClient;

class PhoneClientManager
{
    public $driver;

    public array $data;
    public array $result;

    public function setDriver(PhoneClient $driver)
    {
        $this->driver = $driver;
    }

    public function search(string $phone = ''): self
    {
        $this->phone = $phone;

        $this->data = $this->driver->execute();

        $phoneCode = $this->getPhoneCode(3);

        $result = [];

        $result = $this->driver->findByPhoneCode($phoneCode);

        if(count($result) < 1 || count($result) > 1)
        {
            $phoneCode = $this->getPhoneCode(2);

            $result = $this->driver->findByPhoneCode($phoneCode);
        }

        if(count($result) != 1)
        {
            $phoneCode = $this->getPhoneCode(1);

            $result = $this->driver->findByPhoneCode($phoneCode);
        }

        $this->result = (array) reset($result);

        return $this;
    }


    public function getPhoneCode(int $countNumber): int
    {
        $phone = str_replace('+', '', $this->phone);
        
        return (int) substr($phone, 0, $countNumber);
    }

    public function getCountryCode(): string
    {
        return array_key_exists('country_code', $this->result) ? $this->result['country_code'] : '';
    }

    public function getContryName(): string
    {
        return array_key_exists('country_name', $this->result) ? $this->result['country_name'] : '';
    }
}