<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

class CannotOpenPlanOnThePastException extends \DomainException
{
    public function __construct(PlanId $planId)
    {
        parent::__construct(sprintf('Can not open past plan <%s>', $planId->value()));
    }
}
