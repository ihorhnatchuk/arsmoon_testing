<?php 
namespace App\Service\Report;

use App\Entities\Customer;
use App\Entities\DurationCalls;

final class ReportObject
{
    public Customer $customer;
    
    public int $totalCallsSameContinent;

    public DurationCalls $totalDurationCallsSameContinent;

    public int $totalCalls;

    public DurationCalls $totalDurationCalls;
}
