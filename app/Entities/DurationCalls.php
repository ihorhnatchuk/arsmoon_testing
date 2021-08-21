<?php 
namespace App\Entities;


final class DurationCalls
{
    private function __construct(private int $seconds)
    {
        
    }

    public static function create(int $seconds)
    {
        return new static($seconds);
    }


    public function getTotalSecconds()
    {
        return $this->seconds;
    }

    public function getTotalMinutes()
    {
        return $this->seconds / 60;
    }

    public function getTotalHours()
    {
        return $this->seconds;
    }

    public function __toString()
    {
        return $this->getTotalSecconds().' seconds';
    }
}
