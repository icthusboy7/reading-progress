<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

use Appto\Common\Domain\DateTime\DateTime;

class CannotReadDevotionalBeforeOpenDevotionalException extends \DomainException
{
    public function __construct(DevotionalId $devotionalId)
    {
        parent::__construct(sprintf('Cannot read devotional before open devotional <%s>', $devotionalId->value()));
    }
}
