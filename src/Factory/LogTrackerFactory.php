<?php

namespace App\Factory;

use App\Entity\LogTracker;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(lazy: true)]
class LogTrackerFactory
{
    public function create(string $path): LogTracker
    {
        $logTracker = new LogTracker();

        $logTracker->setPath($path)
            ->setLastProcessedOffset(0)
        ;

        return $logTracker;
    }
}