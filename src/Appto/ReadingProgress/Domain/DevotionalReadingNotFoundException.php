<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

use Appto\Common\Domain\Exception\NotFoundException;

class DevotionalReadingNotFoundException extends \DomainException implements NotFoundException
{
    public function __construct(DevotionalId $devotionalId)
    {
        parent::__construct(sprintf('Devotional reading <%s> not found', $devotionalId->value()));
    }
}
