<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\Persistence\ReadModel\Doctrine;

use Appto\ReadingProgress\Domain\DevotionalReading;
use Appto\ReadingProgress\View\DevotionalReadingView;
use Appto\ReadingProgress\View\DevotionalReadingViewAssembler;

class DoctrineDevotionalReadingViewAssembler implements DevotionalReadingViewAssembler
{
    public function assemble(DevotionalReading $devotionalReading): DevotionalReadingView
    {
        $view = new DevotionalReadingView(
            $devotionalReading->devotionalId()->toString(),
            $devotionalReading->lastOpenedDate()->toString(),
            $devotionalReading->readDate() ? $devotionalReading->readDate()->toString() : null
        );

        return $view;
    }
}
