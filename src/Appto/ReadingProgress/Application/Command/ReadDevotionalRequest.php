<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Command;

class ReadDevotionalRequest
{
    private string $readingProgressId;
    private string $devotionalId;
    private string $readDate;

    public function __construct(
        string $readingProgressId,
        string $devotionalId,
        string $readDate
    ) {
        $this->readingProgressId = $readingProgressId;
        $this->devotionalId = $devotionalId;
        $this->readDate = $readDate;
    }

    public function readingProgressId(): string
    {
        return $this->readingProgressId;
    }

    public function devotionalId(): string
    {
        return $this->devotionalId;
    }

    public function readDate(): string
    {
        return $this->readDate;
    }
}
