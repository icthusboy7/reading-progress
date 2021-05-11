<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

class CannotFinishPlanBeforeStartDateException extends \DomainException
{
    public function __construct(PlanId $planId)
    {
        parent::__construct(sprintf('Cannot finish plan <%s> before start it', $planId->value()));
    }
}
