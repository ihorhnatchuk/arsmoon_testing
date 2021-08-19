<?php 

use App\Api\IpstackClient;
use App\Api\CountryCollingCodeClient;

require __DIR__.'/vendor/autoload.php';


$api = new IpstackClient('37.35.105.218');

print_r($api->execute()->getContinentCode());

$api = new CountryCollingCodeClient();

print_r($api->execute()->getResult());