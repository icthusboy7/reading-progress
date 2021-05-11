<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

class CannotFinishPlanWithUnreadDevotionalException extends \DomainException
{
    public function __construct(PlanId $planId)
    {
        parent::__construct(sprintf('Cannot finish plan <%s> with not read devotionals', $planId->value()));
    }
}
