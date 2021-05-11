<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

class CannotStartPlanBeforeOpenedDateException extends \DomainException
{
    public function __construct(ReadingProgressId $id)
    {
        parent::__construct(sprintf('Reading Progress <%s> Cannot start plan before open it.', $id->value()));
    }
}
