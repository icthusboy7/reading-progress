<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Query;

use Appto\Common\Application\Query\Query;

class ListReadingProgressRequest implements Query
{
    private ?string $planId;
    private ?string $readerId;

    public function __construct(?string $planId, ?string $readerId)
    {
        $this->planId = $planId;
        $this->readerId = $readerId;
    }

    public function planId(): ?string
    {
        return $this->planId;
    }

    public function readerId(): ?string
    {
        return $this->readerId;
    }
}
