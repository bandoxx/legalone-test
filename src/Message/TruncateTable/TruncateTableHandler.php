<?php

namespace App\Message\TruncateTable;

use App\Service\TruncateTable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TruncateTableHandler
{

    public function __construct(
        private readonly TruncateTable $truncateTable
    ) {}

    public function __invoke(TruncateTableMessage $message): void
    {
        $table = $message->getTable();
        $this->truncateTable->truncate($table);
    }
}