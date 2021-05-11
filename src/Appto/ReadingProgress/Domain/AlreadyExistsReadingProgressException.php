<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

class AlreadyExistsReadingProgressException extends \DomainException
{
    public function __construct(string $planId)
    {
        parent::__construct(sprintf('Reading Progress Plan <%s> already exist', $planId));
    }
}
