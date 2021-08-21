<?php

namespace App\Service\Report;

use App\Contracts\ReportBuilder as ReportBuilderContract;

class ReportBuilderManager
{
    private ReportBuilderContract $builder;

    private array $formatedArray;

    protected array $collection = [];

    public function __construct(private array $data)
    {
        $this->groupArrayBy('costomer_id');
    }

    public function groupArrayBy(string $name): void
    {
        $arr = array();

        foreach ($this->data as $key => $item) {
            $arr[$item[$name]][$key] = $item;
         }
         
        ksort($arr, SORT_NUMERIC);

        $this->formatedArray = $arr;
    }

    public function getCollection(): array
    {
        $this->transformArray();

        return $this->collection;
    }

    public function transformArray(): void
    {
        foreach ($this->formatedArray as $key => $value) {
            $data = new ReportBuilderTransformer($value);

            $reportItem = $this->builder->setCustomer($data->getCustomer())
            ->setTotalCallsSameContinent($data->getTotalCallsSameCountry())
            ->setTotalDurationCallsSameContinent($data->getTotalSecondSameCountry())
            ->setTotalCalls($data->getTotalCalls())
            ->setTotalDurationCalls($data->getTotalSecond())
            ->getReportObject();

            $this->collection[] = $reportItem;
        }
    }

    public function setBuilder(ReportBuilderContract $builder): self
    {
        $this->builder = $builder;

        return $this;
    }
}
