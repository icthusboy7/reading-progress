<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

use Appto\Common\Domain\Exception\NotFoundException;

class ReadingProgressNotFoundException extends \DomainException implements NotFoundException
{

    public function __construct(string $planId)
    {
        parent::__construct(sprintf('Reading Progress Plan <%s> not found', $planId));
    }
}
