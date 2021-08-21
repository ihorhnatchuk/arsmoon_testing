<?php 

namespace App\Contracts;

use Core\Contracts\Support\Searchable;

interface PhoneClient
{
    public function execute(): array;

    public function findByPhoneCode(int $code): array;
}