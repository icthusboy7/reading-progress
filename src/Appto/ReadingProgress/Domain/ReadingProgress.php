<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

use Appto\Common\Domain\DateTime\DateTime;
use Appto\Common\Domain\Nullable;

class ReadingProgress
{
    private ReadingProgressId $id;
    private PlanId $planId;
    private DateTime $lastOpenedDate;
    private ?DateTime $startDate;
    private ?DateTime $endDate;
    private $devotionalReadings;
    private ReaderId $readerId;

    public function __construct(
        ReadingProgressId $id,
        PlanId $planId,
        ReaderId $readerId,
        DateTime $lastOpenedDate
    ) {
        $this->id = $id;
        $this->planId = $planId;
        $this->readerId = $readerId;
        $this->lastOpenedDate = $lastOpenedDate;
        $this->devotionalReadings = [];
        $this->startDate = null;
        $this->endDate = null;
    }

    public function openPlan(DateTime $openedDate): void
    {
        if ($openedDate->lowerThan($this->lastOpenedDate)) {
            throw new CannotOpenPlanOnThePastException($this->planId());
        }

        $this->lastOpenedDate = $openedDate;
    }

    public function startPlan(DateTime $startDate): void
    {
        if ($this->isStarted()) {
            throw new AlreadyStartedReadingProgressException($this->id());
        }

        if ($startDate->lowerThan($this->lastOpenedDate)) {
            throw new CannotStartPlanBeforeOpenedDateException($this->id());
        }

        $this->startDate = $startDate;
    }

    public function openDevotional(DevotionalId $devotionalId, DateTime $openDate): void
    {
        if (!$this->isStarted()) {
            throw new CannotOpenDevotionalUnStartedPlanException($this->planId());
        }

        if ($openDate->lowerThan($this->startDate)) {
            throw new CannotOpenDevotionalBeforeStartPlanException($this->planId());
        }

        $devotionalReading = $this->devotionalReading($devotionalId);

        if ($devotionalReading) {
            $devotionalReading->open($openDate);
        } else {
            $devotionalReading = new DevotionalReading($devotionalId, $openDate);
            $this->devotionalReadings[$devotionalId->toString()] = $devotionalReading;
        }
    }

    public function readDevotional(DevotionalId $devotionalId, DateTime $readDate): void
    {
        $devotionalReading = $this->devotionalReading($devotionalId);
        if (!$devotionalReading) {
            throw new DevotionalReadingNotFoundException($devotionalId);
        }

        if ($readDate->lowerThan($devotionalReading->lastOpenedDate())) {
            throw new CannotReadDevotionalBeforeOpenDevotionalException($devotionalId);
        }

        $devotionalReading->read($readDate);
    }

    public function devotionalReading(DevotionalId $devotionalId): ?DevotionalReading
    {
        $devotionalReading = $this->devotionalReadings[$devotionalId->toString()] ?? null;

        return $devotionalReading;
    }

    public function finishPlan(DateTime $endDate): void
    {
        if (!$this->isStarted()) {
            throw new CannotFinishUnstartedPlanException($this->planId());
        }

        if ($endDate->lowerThan($this->startDate)) {
            throw new CannotFinishPlanBeforeStartDateException($this->planId());
        }

        if (!$this->devotionalReadings) {
            throw new CannotFinishPlanWithoutDevotionalsException($this->planId());
        }

        /** @var DevotionalReading $devotionalReading */
        foreach ($this->devotionalReadings as $devotionalReading) {
            if (!$devotionalReading->isRead()) {
                throw new CannotFinishPlanWithUnreadDevotionalException($this->planId());
            }

            if ($endDate->lowerThan($devotionalReading->readDate())) {
                throw new CannotFinishPlanBeforeReadDateException($this->planId());
            }
        }

        $this->endDate = $endDate;
    }

    public function doctrinePostLoad(): void
    {
        $devotionalReadings = $this->devotionalReadings;
        $this->devotionalReadings = [];
        /** @var DevotionalReading $devotionalReading */
        foreach ($devotionalReadings as $devotionalReading) {
            $this->devotionalReadings[$devotionalReading->devotionalId()->toString()] = $devotionalReading;
        }

        if ($this->startDate instanceof Nullable && $this->startDate->isNull()) {
            $this->startDate = null;
        }

        if ($this->endDate instanceof Nullable && $this->endDate->isNull()) {
            $this->endDate = null;
        }
    }

    public function isStarted(): bool
    {
        return null !== $this->startDate();
    }

    public function isFinished(): bool
    {
        return null !== $this->endDate();
    }

    public function id(): ReadingProgressId
    {
        return $this->id;
    }

    public function planId(): PlanId
    {
        return $this->planId;
    }

    public function lastOpenedDate(): DateTime
    {
        return $this->lastOpenedDate;
    }

    public function startDate(): ?DateTime
    {
        return $this->startDate;
    }

    public function endDate(): ?DateTime
    {
        return $this->endDate;
    }

    /**
     * @return DevotionalReading[]
     */
    public function devotionalReadings(): array
    {
        return $this->devotionalReadings;
    }

    public function readerId(): ReaderId
    {
        return $this->readerId;
    }
}
