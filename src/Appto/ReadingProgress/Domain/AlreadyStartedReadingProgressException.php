<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

class AlreadyStartedReadingProgressException extends \DomainException
{
    public function __construct(ReadingProgressId $id)
    {
        parent::__construct(sprintf('Reading Progress <%s> is already started', $id));
    }
}
