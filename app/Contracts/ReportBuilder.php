<?php 
namespace App\Contracts;

use App\Service\Report\ReportObject;

interface ReportBuilder
{
    public function create(): self;

    public function setCustomer(array $customer): self;

    public function setTotalCallsSameContinent(int $calls): self;

    public function setTotalDurationCallsSameContinent(int $seconds): self;

    public function setTotalCalls(int $calls): self;

    public function setTotalDurationCalls(int $seconds): self;

    public function getReportObject(): ReportObject;
}