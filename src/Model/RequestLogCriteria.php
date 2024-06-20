<?php

namespace App\Model;

class RequestLogCriteria
{

    private ?int $statusCode = null;
    private ?\DateTime $startDate = null;
    private ?\DateTime $endDate = null;
    private ?array $serviceNames = null;

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function setStatusCode(?int $statusCode): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): static
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): static
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getServiceNames(): ?array
    {
        return $this->serviceNames;
    }

    public function setServiceNames(?array $serviceNames): static
    {
        $this->serviceNames = $serviceNames;
        return $this;
    }


}