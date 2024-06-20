<?php

namespace App\Message\RequestLogBatch;

use App\Factory\RequestLogFactory;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RequestLogBatchHandler
{

    public function __construct(
        private readonly RequestLogFactory      $requestLogFactory,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger
    ) {}

    public function __invoke(RequestLogBatchMessage $message): void
    {
        $data = json_decode($message->getContent(), true);

        foreach ($data as $log) {
            $record = $this->requestLogFactory->createFromLine($log);

            if (!$record) {
                $this->logger->error(sprintf("Log wronly parsed: %s", $log));
                continue;
            }

            $this->entityManager->persist($record);
        }

        $this->entityManager->flush();
    }

}