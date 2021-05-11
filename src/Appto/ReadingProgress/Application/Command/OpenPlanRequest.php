<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Command;

use Appto\Common\Application\Command\Command;

class OpenPlanRequest implements Command
{
    private string $id;
    private string $planId;
    private string $readerId;
    private string $openDate;

    public function __construct(
        string $id,
        string $planId,
        string $readerId,
        string $openDate
    ) {
        $this->id = $id;
        $this->planId = $planId;
        $this->readerId = $readerId;
        $this->openDate = $openDate;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function planId(): string
    {
        return $this->planId;
    }

    public function readerId(): string
    {
        return $this->readerId;
    }

    public function openDate(): string
    {
        return $this->openDate;
    }
}
