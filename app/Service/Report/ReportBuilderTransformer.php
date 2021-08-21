<?php

namespace App\Service\Report;

use App\Service\IpClient\IpstackClient;
use App\Service\IpClient\IpClientManager;
use App\Service\PhoneClient\PhoneCsvClient;
use App\Service\PhoneClient\PhoneClientManager;

class ReportBuilderTransformer
{
    private array $sameCountry = [];

    private int $customerId;
    private int $totalSecond;
    private int $totalCalls;
    private int $totalSecondSameCountry;
    private int $totalCallsSameCountry;

    public function __construct(private array $data)
    {
        $this->execute();
    }

    public function execute(): self
    {
        $this->customerId = reset($this->data)['costomer_id'];

        $this->totalSecond = $this->countTotalSecconds($this->data);
        $this->totalCalls = count($this->data);

        $this->findSameCalls();

        $this->totalSecondSameCountry = $this->countTotalSecconds($this->sameCountry);
        $this->totalCallsSameCountry = count($this->sameCountry);

        return $this;
    }

    public function countTotalSecconds(array $data):int
    {
        $sumSecconds = 0;
        foreach ($data as $key => $value) {
            $sumSecconds += $value['seconds'];
        }

        return $sumSecconds;
    }

    public function findSameCalls()
    {
        $phoneClienService = new PhoneClientManager();
        $phoneClienService->setDriver(new PhoneCsvClient());

        $ipClientManager = new IpClientManager();
        $ipClientManager->setDriver(new IpstackClient());

        foreach ($this->data as $key => $value) {
            $phoneClienService->search($value['phone']);

            $ipClientManager->driver->search($value['ip']);

            $countryPhone = $phoneClienService->getContryName();
            $countryIp = $ipClientManager->driver->getContryName();

            if($countryPhone === $countryIp)
            {
                $this->sameCountry[] = $value;
            }
        }
    }

    public function getCustomer(): array
    {
        return [
            'id' => $this->customerId
        ];
    }

    public function getTotalSecond():int
    {
        return $this->totalSecond;
    }

    public function getTotalCalls():int
    {
        return $this->totalCalls;
    }

    public function getTotalCallsSameCountry():int
    {
        return $this->totalCallsSameCountry;
    }

    public function getTotalSecondSameCountry():int
    {
        return $this->totalSecondSameCountry;
    }
}
