<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Command;

use Appto\Common\Application\Command\CommandHandler;
use Appto\Common\Domain\DateTime\DateTime;
use Appto\ReadingProgress\Domain\DevotionalId;
use Appto\ReadingProgress\Domain\ReadingProgressRepository;

class OpenDevotional implements CommandHandler
{
    private ReadingProgressRepository $readingProgressRepository;

    public function __construct(ReadingProgressRepository $readingProgressRepository)
    {
        $this->readingProgressRepository = $readingProgressRepository;
    }

    public function __invoke(OpenDevotionalRequest $command): void
    {
        $readingProgress = $this->readingProgressRepository->get($command->readingProgressId());

        $readingProgress->openDevotional(
            new DevotionalId($command->devotionalId()),
            DateTime::fromString($command->openDate())
        );

        $this->readingProgressRepository->save($readingProgress);
    }
}
