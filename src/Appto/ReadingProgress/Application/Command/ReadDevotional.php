<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Command;

use Appto\Common\Application\Command\CommandHandler;
use Appto\Common\Domain\DateTime\DateTime;
use Appto\ReadingProgress\Domain\DevotionalId;
use Appto\ReadingProgress\Domain\ReadingProgressRepository;

class ReadDevotional implements CommandHandler
{
    private ReadingProgressRepository $readingProgressRepository;

    public function __construct(ReadingProgressRepository $readingProgressRepository)
    {
        $this->readingProgressRepository = $readingProgressRepository;
    }

    public function __invoke(ReadDevotionalRequest $command): void
    {
        $readingProgress = $this->readingProgressRepository->get($command->readingProgressId());

        $readingProgress->readDevotional(
            new DevotionalId($command->devotionalId()),
            DateTime::fromString($command->readDate())
        );

        $this->readingProgressRepository->save($readingProgress);
    }
}
