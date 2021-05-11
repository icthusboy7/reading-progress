<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\View;

use Appto\ReadingProgress\Domain\ReadingProgress;

interface ReadingProgressViewAssembler
{
    public function assemble(ReadingProgress $readingProgress): ReadingProgressView;
}
