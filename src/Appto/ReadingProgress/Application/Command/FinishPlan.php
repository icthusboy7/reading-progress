<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Command;

use Appto\Common\Application\Command\CommandHandler;
use Appto\Common\Domain\DateTime\DateTime;
use Appto\ReadingProgress\Domain\ReadingProgressNotFoundException;
use Appto\ReadingProgress\Domain\ReadingProgressRepository;

class FinishPlan implements CommandHandler
{
    private ReadingProgressRepository $readingProgressRepository;

    public function __construct(ReadingProgressRepository $readingProgressRepository)
    {
        $this->readingProgressRepository = $readingProgressRepository;
    }

    public function __invoke(FinishPlanRequest $command): void
    {
        $readingProgress = $this->readingProgressRepository->get($command->readingProgressId());

        $finishDate = DateTime::fromString($command->finishDate());

        $readingProgress->finishPlan($finishDate);

        $this->readingProgressRepository->save($readingProgress);
    }
}
