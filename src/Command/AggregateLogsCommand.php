<?php

namespace App\Command;

use App\Service\LogFileParser;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\FlockStore;
use Symfony\Component\Lock\Store\SemaphoreStore;

#[AsCommand(
    name: 'app:aggregate-logs',
    description: 'Function for reading log file and putting batches in queue',
)]
class AggregateLogsCommand extends Command
{
    public function __construct(
        private readonly LogFileParser $logFileParser,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $factory = new LockFactory(new FlockStore());

        $lock = $factory->createLock('log-aggregation');

        if ($lock->acquire()) {
            $filePath = sprintf("%s/../../test-data/logs.log", __DIR__);

            try {
                $this->logFileParser->parseLogFile($filePath);
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
            } finally {
                $lock->release();
            }
        }

        return Command::SUCCESS;
    }
}
