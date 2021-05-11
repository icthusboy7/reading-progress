<?php
declare(strict_types=1);

namespace Test\Unit\Appto\ReadingProgress\Domain;

use Appto\Common\Infrastructure\PHPUnit\Mother;
use Appto\Common\Domain\DateTime\DateTime;
use Appto\ReadingProgress\Domain\PlanId;
use Appto\ReadingProgress\Domain\ReaderId;
use Appto\ReadingProgress\Domain\ReadingProgress;
use Appto\ReadingProgress\Domain\ReadingProgressId;

class ReadingProgressMother extends Mother
{
    public static function create(
        string $id,
        string $planId,
        string $readerId,
        DateTime $openDate
    ) : ReadingProgress {
        return new ReadingProgress(
            new ReadingProgressId($id),
            new PlanId($planId),
            new ReaderId($readerId),
            $openDate
        );
    }

    public static function startPlan(
        string $id,
        string $planId,
        string $readerId,
        DateTime $openDate,
        DateTime $startDate
    ) : ReadingProgress {
        $openPlan = self::create($id, $planId, $readerId, $openDate);
        $openPlan->startPlan($startDate);

        return $openPlan;
    }

    public static function openPlanRandom(DateTime $openDate): ReadingProgress
    {
        return self::create(
            self::faker()->uuid,
            self::faker()->uuid,
            self::faker()->uuid,
            $openDate
        );
    }

    public static function startPlanRandom(DateTime $openDate, DateTime $startDate): ReadingProgress
    {
        return self::startPlan(
            self::faker()->uuid,
            self::faker()->uuid,
            self::faker()->uuid,
            $openDate,
            $startDate
        );
    }
}