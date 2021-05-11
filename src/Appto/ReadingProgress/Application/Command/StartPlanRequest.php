<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Command;

use Appto\Common\Application\Command\Command;

class StartPlanRequest implements Command
{
    private string $readingProgressId;
    private string $startDate;

    public function __construct(
        string $readingProgressId,
        string $startDate
    ) {
        $this->readingProgressId = $readingProgressId;
        $this->startDate = $startDate;
    }

    public function readingProgressId(): string
    {
        return $this->readingProgressId;
    }

    public function startDate(): string
    {
        return $this->startDate;
    }
}
