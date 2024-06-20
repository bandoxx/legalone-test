<?php

namespace App\Message\RequestLogBatch;

class RequestLogBatchMessage
{

    public function __construct(
        private readonly string $content
    ) {}

    public function getContent(): string
    {
        return $this->content;
    }
}