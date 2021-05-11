<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\View;

use Appto\ReadingProgress\Domain\DevotionalReading;

interface DevotionalReadingViewAssembler
{
    public function assemble(DevotionalReading $devotionalReading): DevotionalReadingView;
}
