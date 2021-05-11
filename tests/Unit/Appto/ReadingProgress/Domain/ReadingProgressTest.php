<?php
declare(strict_types=1);

namespace Test\Unit\Appto\ReadingProgress\Domain;

use Appto\Common\Domain\DateTime\DateTime;
use Appto\Common\Infrastructure\PHPUnit\UnitTest;
use Appto\ReadingProgress\Domain\AlreadyReadDevotionalException;
use Appto\ReadingProgress\Domain\CannotFinishPlanBeforeReadDateException;
use Appto\ReadingProgress\Domain\CannotFinishPlanWithoutDevotionalsException;
use Appto\ReadingProgress\Domain\CannotFinishUnstartedPlanException;
use Appto\ReadingProgress\Domain\CannotOpenDevotionalUnStartedPlanException;
use Appto\ReadingProgress\Domain\CannotFinishPlanWithUnreadDevotionalException;
use Appto\ReadingProgress\Domain\CannotOpenDevotionalBeforeStartPlanException;
use Appto\ReadingProgress\Domain\CannotReadDevotionalBeforeOpenDevotionalException;
use Appto\ReadingProgress\Domain\CannotOpenDevotionalOnThePastException;
use Appto\ReadingProgress\Domain\DevotionalId;
use Appto\ReadingProgress\Domain\CannotFinishPlanBeforeStartDateException;
use Appto\ReadingProgress\Domain\CannotOpenPlanOnThePastException;
use Appto\ReadingProgress\Domain\CannotStartPlanBeforeOpenedDateException;
use Appto\ReadingProgress\Domain\DevotionalReadingNotFoundException;

class ReadingProgressTest extends UnitTest
{
    public function testSuccessfullyOpensPlan(): void
    {
        $openedDate = DateTime::now();
        $readingProgress = ReadingProgressMother::openPlanRandom($openedDate);

        self::assertNotNull($readingProgress->lastOpenedDate());
        self::assertNull($readingProgress->startDate());
        self::assertEmpty($readingProgress->devotionalReadings());
    }

    public function testSuccessfullyReOpenPlan(): void
    {
        $openedDate = DateTime::now();
        $readingProgress = ReadingProgressMother::openPlanRandom($openedDate);
        $reOpenedDate = DateTime::now()->add('P1D');
        $readingProgress->openPlan($reOpenedDate);

        self::assertSame($readingProgress->lastOpenedDate(), $reOpenedDate);
        self::assertNull($readingProgress->startDate());
        self::assertEmpty($readingProgress->devotionalReadings());
    }

    public function testFailsToReopenPastPlan(): void
    {
        $this->expectException(CannotOpenPlanOnThePastException::class);

        $openedDate = DateTime::now();
        $readingProgress = ReadingProgressMother::openPlanRandom($openedDate);

        $pastDate = DateTime::now()->sub('P10D');
        $readingProgress->openPlan($pastDate);
    }

    public function testSuccessStartPlan(): void
    {
        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now();
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        self::assertNotNull($readingProgress->startDate());
        self::assertNull($readingProgress->endDate());
        self::assertEmpty($readingProgress->devotionalReadings());
        self::assertSame($startDate, $readingProgress->startDate());
    }

    public function testFailsToStartPlanBeforeOpenedDate(): void
    {
        $this->expectException(CannotStartPlanBeforeOpenedDateException::class);

        $openDate = DateTime::now()->sub('P9D');
        $startDate = DateTime::now()->sub('P10D');
        ReadingProgressMother::startPlanRandom($openDate, $startDate);
    }

    public function testSuccessOpenDevotional(): void
    {
        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $openDateDevotional = DateTime::now()->sub('P4D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);

        self::assertNotEmpty($readingProgress->devotionalReadings());

        self::assertTrue($readingProgress->devotionalReading($devotionalId)->isOpen());
        self::assertFalse($readingProgress->devotionalReading($devotionalId)->isRead());
        self::assertSame($openDateDevotional, $readingProgress->devotionalReading($devotionalId)->lastOpenedDate());
    }

    public function testFailsOpenDevotionalUnStartedPlan(): void
    {
        $this->expectException(CannotOpenDevotionalUnStartedPlanException::class);

        $openedDate = DateTime::now()->sub('P10D');
        $readingProgress = ReadingProgressMother::openPlanRandom($openedDate);

        $openDateDevotional = DateTime::now()->sub('P6D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);
    }

    public function testFailsOpenDevotionalBeforeStartPlan(): void
    {
        $this->expectException(CannotOpenDevotionalBeforeStartPlanException::class);

        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $openDateDevotional = DateTime::now()->sub('P6D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);
    }

    public function testSuccessReOpenDevotional(): void
    {
        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $openDateDevotional = DateTime::now()->sub('P4D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);

        $reOpenDateDevotional = DateTime::now()->sub('P3D');
        $readingProgress->openDevotional($devotionalId, $reOpenDateDevotional);

        self::assertSame($reOpenDateDevotional, $readingProgress->devotionalReading($devotionalId)->lastOpenedDate());
        self::assertTrue($readingProgress->devotionalReading($devotionalId)->isOpen());
        self::assertFalse($readingProgress->devotionalReading($devotionalId)->isRead());
    }

    public function testFailReOpenDevotionalOnThePast(): void
    {
        $this->expectException(CannotOpenDevotionalOnThePastException::class);

        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $openDateDevotional = DateTime::now()->sub('P3D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);

        $reOpenDateDevotional = DateTime::now()->sub('P4D');
        $readingProgress->openDevotional($devotionalId, $reOpenDateDevotional);

    }

    public function testSuccessReadDevotional(): void
    {
        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $openDateDevotional = DateTime::now()->sub('P4D');
        $openDateOtherDevotional = DateTime::now()->sub('P3D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $otherDevotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);
        $readingProgress->openDevotional($otherDevotionalId, $openDateOtherDevotional);

        $readDateDevotional = DateTime::now()->sub('P2D');
        $readingProgress->readDevotional($devotionalId, $readDateDevotional);

        self::assertNotEmpty($readingProgress->devotionalReadings());
        self::assertTrue($readingProgress->devotionalReading($devotionalId)->isOpen());
        self::assertTrue($readingProgress->devotionalReading($devotionalId)->isRead());
        self::assertFalse($readingProgress->devotionalReading($otherDevotionalId)->isRead());
        self::assertSame($readDateDevotional, $readingProgress->devotionalReading($devotionalId)->readDate());
    }

    public function testFailsReadDevotionalWhenIsRead(): void
    {
        $this->expectException(AlreadyReadDevotionalException::class);

        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $openDateDevotional = DateTime::now()->sub('P4D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);

        $readDateDevotional = DateTime::now()->sub('P2D');
        $readingProgress->readDevotional($devotionalId, $readDateDevotional);

        $readDateDevotional = DateTime::now()->sub('P2D');
        $readingProgress->readDevotional($devotionalId, $readDateDevotional);
    }

    public function testFailsReadDevotionalBeforeOpenDevotional(): void
    {
        $this->expectException(CannotReadDevotionalBeforeOpenDevotionalException::class);

        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P6D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $openDateDevotional = DateTime::now()->sub('P4D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);

        $readDateDevotional = DateTime::now()->sub('P5D');
        $readingProgress->readDevotional($devotionalId, $readDateDevotional);
    }

    public function testFailsReadDevotionalWhenDevotionalNotExist(): void
    {
        $this->expectException(DevotionalReadingNotFoundException::class);
        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readDateDevotional = DateTime::now()->sub('P2D');
        $readingProgress->readDevotional($devotionalId, $readDateDevotional);
    }

    public function testSuccessFinishPlan(): void
    {
        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $openDateDevotional = DateTime::now()->sub('P4D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);

        $readDateDevotional = DateTime::now()->sub('P3D');
        $readingProgress->readDevotional($devotionalId, $readDateDevotional);

        $endDate = DateTime::now()->sub('P2D');
        $readingProgress->finishPlan($endDate);

        self::assertNotEmpty($readingProgress->devotionalReadings());
        self::assertNotNull($readingProgress->endDate());
        self::assertTrue($readingProgress->devotionalReading($devotionalId)->isRead());
    }

    public function testFailsToFinishPlanBeforeStartDate(): void
    {
        $this->expectException(CannotFinishPlanBeforeStartDateException::class);

        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $endDate = DateTime::now()->sub('P6D');
        $readingProgress->finishPlan($endDate);
    }

    public function testFailsToFinishNotStartedPlan(): void
    {
        $this->expectException(CannotFinishUnstartedPlanException::class);

        $openedDate = DateTime::now()->sub('P10D');
        $readingProgress = ReadingProgressMother::openPlanRandom($openedDate);

        $endDate = DateTime::now()->sub('P6D');
        $readingProgress->finishPlan($endDate);
    }

    public function testFailFinishStartedPlanWithoutDevotionalReadings(): void
    {
        $this->expectException(CannotFinishPlanWithoutDevotionalsException::class);

        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $endDate = DateTime::now()->sub('P3D');
        $readingProgress->finishPlan($endDate);
    }

    public function testFailsFinishPlanWhenADevotionalIsNotRead(): void
    {
        $this->expectException(CannotFinishPlanWithUnreadDevotionalException::class);

        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P6D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $openDateDevotional = DateTime::now()->sub('P4D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);

        $endDate = DateTime::now()->sub('P2D');
        $readingProgress->finishPlan($endDate);
    }

    public function testFailsFinishPlanBeforeDevotionalRead(): void
    {
        $this->expectException(CannotFinishPlanBeforeReadDateException::class);

        $openDate = DateTime::now()->sub('P10D');
        $startDate = DateTime::now()->sub('P5D');
        $readingProgress = ReadingProgressMother::startPlanRandom($openDate, $startDate);

        $openDateDevotional = DateTime::now()->sub('P4D');
        $devotionalId = new DevotionalId($this->faker->uuid);
        $readingProgress->openDevotional($devotionalId, $openDateDevotional);

        $readDateDevotional = DateTime::now()->sub('P2D');
        $readingProgress->readDevotional($devotionalId, $readDateDevotional);

        $endDate = DateTime::now()->sub('P3D');
        $readingProgress->finishPlan($endDate);
    }
}