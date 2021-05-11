<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

class AlreadyReadDevotionalException extends \DomainException
{
    public function __construct(DevotionalId $devotionalId)
    {
        parent::__construct(sprintf('Devotional <%s> is already read', $devotionalId));
    }
}
