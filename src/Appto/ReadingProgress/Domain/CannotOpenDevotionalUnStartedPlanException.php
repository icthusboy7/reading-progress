<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

class CannotOpenDevotionalUnStartedPlanException extends \DomainException
{
    public function __construct(PlanId $planId)
    {
        parent::__construct(sprintf('Cannot open devotional before plan started  <%s>', $planId->value()));
    }
}
