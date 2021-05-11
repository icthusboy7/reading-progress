<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\Persistence\ReadModel\Doctrine;

use Appto\ReadingProgress\Domain\DevotionalReading;
use Appto\ReadingProgress\Domain\ReadingProgress;
use Appto\ReadingProgress\View\DevotionalReadingView;
use Appto\ReadingProgress\View\DevotionalReadingViewAssembler;
use Appto\ReadingProgress\View\ReadingProgressView;
use Appto\ReadingProgress\View\ReadingProgressViewAssembler;

class DoctrineReadingProgressViewAssembler implements ReadingProgressViewAssembler
{
    private DevotionalReadingViewAssembler $devotionalReadingViewAssembler;

    public function __construct(DevotionalReadingViewAssembler $devotionalReadingViewAssembler)
    {
        $this->devotionalReadingViewAssembler = $devotionalReadingViewAssembler;
    }

    public function assemble(ReadingProgress $readingProgress): ReadingProgressView
    {
        $view = new ReadingProgressView(
            $readingProgress->id()->toString(),
            $readingProgress->planId()->toString(),
            $readingProgress->readerId()->toString(),
            $readingProgress->lastOpenedDate()->toString(),
            $readingProgress->startDate() ? $readingProgress->startDate()->toString() : null,
            $readingProgress->endDate() ? $readingProgress->endDate()->toString() : null,
            $this->assembleDevotionalReadings($readingProgress->devotionalReadings()),
        );

        return $view;
    }

    /**
     * @param DevotionalReading[] $devotionalReadings
     * @return DevotionalReadingView[]
     */
    private function assembleDevotionalReadings(array $devotionalReadings): array
    {
        return array_map(
            fn(DevotionalReading $devotionalReading) =>
            $this->devotionalReadingViewAssembler->assemble($devotionalReading),
            $devotionalReadings
        );
    }
}
