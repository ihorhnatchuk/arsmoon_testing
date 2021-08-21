<?php 

namespace App\Service\IpClient;

use App\Contracts\IpClient;
use App\Contracts\PhoneClient;

class IpClientManager
{
    public $driver;

    public array $data;
    public array $result;

    public function setDriver(IpClient $driver)
    {
        $this->driver = $driver;
    }
}