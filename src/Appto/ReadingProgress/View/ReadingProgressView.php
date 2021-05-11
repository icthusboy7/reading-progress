<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\View;

use Appto\Common\View\View;

class ReadingProgressView implements View
{
    public $id;

    public $planId;

    public $readerId;

    public $lastOpenedDate;

    public $startDate;

    public $endDate;

    /**
     * @var DevotionalReadingView[]
     */
    public $devotionalReadings;

    public function __construct(
        string $id,
        string $planId,
        string $readerId,
        string $lastOpenedDate,
        ?string $startDate,
        ?string $endDate,
        array $devotionalReadings
    ) {
        $this->id = $id;
        $this->planId = $planId;
        $this->readerId = $readerId;
        $this->lastOpenedDate = $lastOpenedDate;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->devotionalReadings = $devotionalReadings;
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

    public function lastOpenedDate(): string
    {
        return $this->lastOpenedDate;
    }

    public function startDate(): ?string
    {
        return $this->startDate;
    }

    public function endDate(): ?string
    {
        return $this->endDate;
    }

    public function devotionalReadings(): array
    {
        return $this->devotionalReadings;
    }
}
