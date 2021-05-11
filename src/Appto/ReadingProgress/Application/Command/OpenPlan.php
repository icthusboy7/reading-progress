<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Command;

use Appto\Common\Application\Command\CommandHandler;
use Appto\Common\Domain\DateTime\DateTime;
use Appto\ReadingProgress\Domain\AlreadyExistsReadingProgressException;
use Appto\ReadingProgress\Domain\PlanId;
use Appto\ReadingProgress\Domain\ReaderId;
use Appto\ReadingProgress\Domain\ReadingProgress;
use Appto\ReadingProgress\Domain\ReadingProgressId;
use Appto\ReadingProgress\Domain\ReadingProgressRepository;

class OpenPlan implements CommandHandler
{
    private ReadingProgressRepository $readingProgressRepository;

    public function __construct(ReadingProgressRepository $readingProgressRepository)
    {
        $this->readingProgressRepository = $readingProgressRepository;
    }

    public function __invoke(OpenPlanRequest $command): void
    {
        $readingProgress = $this->readingProgressRepository->findBy($command->planId(), $command->readerId());

        $openDate = DateTime::fromString($command->openDate());

        if ($readingProgress) {
            if (!$readingProgress->id()->equals(new ReadingProgressId($command->id()))) {
                throw new AlreadyExistsReadingProgressException($command->planId());
            }
            $readingProgress->openPlan($openDate);
        } else {
            $readingProgress = new ReadingProgress(
                new ReadingProgressId($command->id()),
                new PlanId($command->planId()),
                new ReaderId($command->readerId()),
                $openDate
            );
        }

        $this->readingProgressRepository->save($readingProgress);
    }
}
