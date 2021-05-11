<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

use Appto\Common\Domain\DateTime\DateTime;
use Appto\Common\Domain\Nullable;

class DevotionalReading
{
    private DevotionalId $devotionalId;
    private DateTime $lastOpenedDate;
    private ?DateTime $readDate;

    /** @var string $entityId ONLY FOR DOCTRINE MAPPING*/
    private $entityId;

    public function __construct(
        DevotionalId $devotionalId,
        DateTime $lastOpenedDate
    ) {
        $this->devotionalId = $devotionalId;
        $this->lastOpenedDate = $lastOpenedDate;
        $this->readDate = null;
    }

    public function open(DateTime $openDate): void
    {
        if ($openDate->lowerThan($this->lastOpenedDate())) {
            throw new CannotOpenDevotionalOnThePastException($this->devotionalId(), $openDate);
        }

        $this->lastOpenedDate = $openDate;
    }

    public function read(DateTime $readDate): void
    {
        if ($this->isRead()) {
            throw new AlreadyReadDevotionalException($this->devotionalId());
        }

        $this->readDate = $readDate;
    }

    public function isOpen(): bool
    {
        return null !== $this->lastOpenedDate();
    }

    public function isRead(): bool
    {
        return null !== $this->readDate();
    }

    public function doctrinePostLoad(): void
    {
        if ($this->readDate instanceof Nullable && $this->readDate->isNull()) {
            $this->readDate = null;
        }
    }

    public function devotionalId(): DevotionalId
    {
        return $this->devotionalId;
    }

    public function lastOpenedDate(): DateTime
    {
        return $this->lastOpenedDate;
    }

    public function readDate(): ?DateTime
    {
        return $this->readDate;
    }
}
