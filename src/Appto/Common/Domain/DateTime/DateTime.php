<?php

declare(strict_types=1);

namespace Appto\Common\Domain\DateTime;

use Appto\Common\Domain\Nullable;
use DateInterval;
use DateTimeImmutable;
use DateTimeZone;

final class DateTime implements Nullable
{
    private const FORMAT_STRING = 'Y-m-d\TH:i:sP';

    private ?DateTimeImmutable $dateTime;

    private function __construct(DateTimeImmutable $dateTime)
    {
        if (!$this->isValid($dateTime)) {
            throw new InvalidDateTimeException($dateTime->format(self::FORMAT_STRING));
        }
        $this->dateTime = $dateTime;
    }

    public function isValid(DateTimeImmutable $dateTime): bool
    {
        return $dateTime->getTimezone()->getName() == '+00:00';
    }

    public static function now(): self
    {
        return new self(
            DateTimeImmutable::createFromFormat(
                'U.u',
                sprintf('%.6F', microtime(true)),
                new DateTimeZone('UTC')
            )
        );
    }

    public function toString(): string
    {
        return $this->dateTime->format(self::FORMAT_STRING);
    }

    public static function fromString(string $dateTimeString): self
    {
        if (!self::isValidStringDate($dateTimeString)) {
            throw new InvalidStringDateTimeException($dateTimeString);
        }
        return new self(new DateTimeImmutable($dateTimeString));
    }

    private static function isValidStringDate(string $dateTimeString): bool
    {
        return (bool)strtotime($dateTimeString);
    }

    public function equals(self $dateTime): bool
    {
        return $this->toString() === $dateTime->toString();
    }

    public function lowerThan(self $dateTime): bool
    {
        return $this->dateTime < $dateTime->dateTime;
    }

    public function greaterThan(self $dateTime): bool
    {
        return $this->dateTime > $dateTime->dateTime;
    }

    public function add(string $intervalSpec): self
    {
        $dateTime = $this->dateTime->add(new DateInterval($intervalSpec));

        return new self($dateTime);
    }

    public function sub(string $intervalSpec): self
    {
        $dateTime = $this->dateTime->sub(new DateInterval($intervalSpec));

        return new self($dateTime);
    }

    public function diff(self $dateTime): DateInterval
    {
        return $this->dateTime->diff($dateTime->dateTime);
    }

    public function toBeginningOfWeek(): self
    {
        return new self(new DateTimeImmutable($this->dateTime->format('o-\WW-1'), new DateTimeZone('UTC')));
    }

    public function toYearWeekString(): string
    {
        return $this->dateTime->format('oW');
    }

    public function toNative(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function isNull(): bool
    {
        return null === $this->dateTime;
    }
}
