<?php 

namespace App\Service\PhoneClient;

use Exception;
use App\Contracts\PhoneClient;

class PhoneCsvClient implements PhoneClient
{
    private array $data;

    public function execute(): array
    {
        try {
            $result = file_get_contents( STORAGE_PATH.'/country-code.json');
        } catch (Exception $e) {
                echo $e;
        }

        $this->data = (array) json_decode($result);

        return (array) json_decode($result);
    }

    public function findByPhoneCode(int $code): array
    {
        $result = [];

        $code = '+'.$code;

        foreach ($this->data as $key => $value) {
            foreach ($value->countryCallingCodes as $key2 => $phoneCode) {
                if($code === $phoneCode)
                {
                  $result[] = [
                      'phone_code' => $phoneCode,
                      'country_name' => $value->name,
                      'country_code' => $value->alpha2,
                  ];
                }
            }
        }

        return $result;
    }
}