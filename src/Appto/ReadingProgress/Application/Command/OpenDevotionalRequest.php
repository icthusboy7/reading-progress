<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Command;

class OpenDevotionalRequest
{
    private string $readingProgressId;
    private string $devotionalId;
    private string $openDate;

    public function __construct(
        string $readingProgressId,
        string $devotionalId,
        string $openDate
    ) {
        $this->readingProgressId = $readingProgressId;
        $this->devotionalId = $devotionalId;
        $this->openDate = $openDate;
    }

    public function readingProgressId(): string
    {
        return $this->readingProgressId;
    }

    public function devotionalId(): string
    {
        return $this->devotionalId;
    }

    public function openDate(): string
    {
        return $this->openDate;
    }
}
