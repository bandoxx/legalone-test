<?php

namespace App\Message\TruncateTable;

class TruncateTableMessage
{

    public function __construct(
        private readonly string $table
    ) {}

    public function getTable(): string
    {
        return $this->table;
    }
}