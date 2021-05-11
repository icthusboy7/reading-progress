<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Command;

use Appto\Common\Application\Command\CommandHandler;
use Appto\Common\Domain\DateTime\DateTime;
use Appto\ReadingProgress\Domain\ReadingProgressRepository;

class StartPlan implements CommandHandler
{
    private ReadingProgressRepository $readingProgressRepository;

    public function __construct(ReadingProgressRepository $readingProgressRepository)
    {
        $this->readingProgressRepository = $readingProgressRepository;
    }

    public function __invoke(StartPlanRequest $command): void
    {
        $readingProgress = $this->readingProgressRepository->get($command->readingProgressId());

        $startDate = DateTime::fromString($command->startDate());

        $readingProgress->startPlan($startDate);

        $this->readingProgressRepository->save($readingProgress);
    }
}
