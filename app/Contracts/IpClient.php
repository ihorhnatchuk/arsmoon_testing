<?php 

namespace App\Contracts;

use Core\Contracts\Support\Searchable;

interface IpClient extends Searchable
{
    public function execute(): self;

    public function getContinentCode(): string;

    public function getContinentName(): string;

    public function getCountryCode(): string;

    public function getContryName(): string;
}