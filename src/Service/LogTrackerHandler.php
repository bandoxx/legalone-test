<?php

namespace App\Service;

use App\Entity\LogTracker;
use App\Factory\LogTrackerFactory;
use App\Repository\LogTrackerRepository;
use Doctrine\ORM\EntityManagerInterface;

class LogTrackerHandler
{

    public function __construct(
        private readonly LogTrackerRepository   $logTrackerRepository,
        private readonly LogTrackerFactory      $logTrackerFactory,
        private readonly EntityManagerInterface $entityManager
    )
    {}

    public function getLogTracker(string $path): LogTracker
    {
        $tracker = $this->logTrackerRepository->findOneBy(['path' => $path]);

        if (!$tracker) {
            $tracker = $this->logTrackerFactory->create($path);
            $this->entityManager->persist($tracker);
            $this->entityManager->flush();
        }

        return $tracker;
    }
}