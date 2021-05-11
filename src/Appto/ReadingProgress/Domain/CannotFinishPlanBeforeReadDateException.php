<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

class CannotFinishPlanBeforeReadDateException extends \DomainException
{
    public function __construct(PlanId $planId)
    {
        parent::__construct(sprintf('Cannot finish plan <%s> before read devotionals', $planId->value()));
    }
}
