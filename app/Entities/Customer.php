<?php 
namespace App\Entities;

final class Customer
{
    private function __construct(private int $id)
    {
        
    }

    public static function create(int $customerId)
    {
        return new static($customerId);
    }

    public function getId()
    {
        return $this->id;
    }
}
