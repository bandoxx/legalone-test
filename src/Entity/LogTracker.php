<?php

namespace App\Entity;

use App\Repository\LogTrackerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogTrackerRepository::class)]
class LogTracker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 255)]
    private ?string $lastProcessedOffset = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getLastProcessedOffset(): ?string
    {
        return $this->lastProcessedOffset;
    }

    public function setLastProcessedOffset(string $lastProcessedOffset): static
    {
        $this->lastProcessedOffset = $lastProcessedOffset;

        return $this;
    }
}
