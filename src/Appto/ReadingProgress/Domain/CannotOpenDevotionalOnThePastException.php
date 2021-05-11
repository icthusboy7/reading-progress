<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

use Appto\Common\Domain\DateTime\DateTime;

class CannotOpenDevotionalOnThePastException extends \DomainException
{
    public function __construct(DevotionalId $devotionalId, DateTime $openedDate)
    {
        parent::__construct(
            sprintf(
                'Cannot open devotional <%s> on the past <%s>',
                $devotionalId->value(),
                $openedDate->toString()
            )
        );
    }
}
