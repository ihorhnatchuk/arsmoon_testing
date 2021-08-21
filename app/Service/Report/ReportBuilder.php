<?php 
namespace App\Service\Report;

use App\Entities\Customer;
use App\Contracts\ReportBuilder as ReportBuilderContract;
use App\Entities\DurationCalls; 

class ReportBuilder implements ReportBuilderContract
{
    private $reportObject;

    public function __construct()
    {
        $this->create();
    }

    public function create(): self
    {
        $this->reportObject = new ReportObject();

        return $this;
    }

    public function setCustomer(array $customer): self
    {
        $this->reportObject->customer = Customer::create($customer['id']);

        return $this;
    }

    public function setTotalCallsSameContinent(int $calls): self
    {
        $this->reportObject->totalCallsSameContinent = $calls;
        
        return $this;
    }

    public function setTotalDurationCallsSameContinent(int $seconds): self
    {
        $this->reportObject->totalDurationCallsSameContinent = DurationCalls::create($seconds);

        return $this;
    }

    public function setTotalCalls(int $calls): self
    {
        $this->reportObject->totalCalls = $calls;
        
        return $this;
    }

    public function setTotalDurationCalls(int $seconds): self
    {
        $this->reportObject->totalDurationCalls = DurationCalls::create($seconds);

        return $this;
    }

    public function getReportObject(): ReportObject
    {
        $result = $this->reportObject;
        $this->create();

        return $result;

    }
}