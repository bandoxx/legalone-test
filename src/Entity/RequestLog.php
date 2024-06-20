<?php

namespace App\Entity;

use App\Repository\RequestLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestLogRepository::class)]
#[ORM\Table(name: 'request_log')]
#[ORM\Index(name: 'idx_status_code_date', columns: ['status_code', 'date'])]
#[ORM\Index(name: 'idx_status_code_service_name', columns: ['service_name', 'status_code'])]
#[ORM\Index(name: 'idx_service_name_date', columns: ['service_name', 'date'])]
class RequestLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $serviceName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $statusCode = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): static
    {
        $this->serviceName = $serviceName;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}