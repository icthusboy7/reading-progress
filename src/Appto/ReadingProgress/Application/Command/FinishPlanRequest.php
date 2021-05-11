<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Command;

use Appto\Common\Application\Command\Command;

class FinishPlanRequest implements Command
{
    private string $readingProgressId;
    private string $finishDate;

    public function __construct(
        string $readingProgressId,
        string $finishDate
    ) {
        $this->readingProgressId = $readingProgressId;
        $this->finishDate = $finishDate;
    }

    public function readingProgressId(): string
    {
        return $this->readingProgressId;
    }

    public function finishDate(): string
    {
        return $this->finishDate;
    }
}
