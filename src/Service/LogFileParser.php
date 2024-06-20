<?php

namespace App\Service;

use App\Entity\LogTracker;
use App\Message\RequestLogBatch\RequestLogBatchMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Messenger\MessageBusInterface;

class LogFileParser
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LogTrackerHandler      $logTrackerHandler,
        private readonly MessageBusInterface    $bus
    ) {}

    public function parseLogFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException("Log file doesn't exist!");
        }

        $logTracker = $this->logTrackerHandler->getLogTracker($filePath);
        $handle = $this->openFile($filePath);

        try {
            $this->processLogFile($handle, $logTracker);
        } finally {
            fclose($handle);
            $this->entityManager->flush();
        }
    }

    private function openFile(string $filePath)
    {
        $handle = fopen($filePath, 'rb');

        if ($handle === false) {
            throw new FileException("Error opening the file.");
        }

        return $handle;
    }

    private function processLogFile($handle, LogTracker $logTracker): void
    {
        $chunkSize = 1024 * 10; // approximately 260 logs in batch
        fseek($handle, $logTracker->getLastProcessedOffset());

        while (!feof($handle)) {
            $chunk = fread($handle, $chunkSize);

            if ($chunk === false) {
                throw new FileException("Error reading the file.");
            }

            if (empty($chunk)) {
                return;
            }

            $lines = explode("\n", $chunk);
            $lastLine = array_pop($lines);

            $this->bus->dispatch(new RequestLogBatchMessage(json_encode($lines)));

            if (!feof($handle)) {
                fseek($handle, -strlen($lastLine), SEEK_CUR);
            }

            $logTracker->setLastProcessedOffset(ftell($handle));
        }
    }
}