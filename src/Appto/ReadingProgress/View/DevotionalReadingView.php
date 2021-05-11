<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\View;

use Appto\Common\View\View;

class DevotionalReadingView implements View
{
    public $devotionalId;

    public $lastOpenedDate;

    public $readDate;

    public function __construct(string $devotionalId, string $lastOpenedDate, ?string $readDate)
    {
        $this->devotionalId = $devotionalId;
        $this->lastOpenedDate = $lastOpenedDate;
        $this->readDate = $readDate;
    }

    public function devotionalId(): string
    {
        return $this->devotionalId;
    }

    public function lastOpenedDate(): string
    {
        return $this->lastOpenedDate;
    }

    public function readDate(): ?string
    {
        return $this->readDate;
    }
}
