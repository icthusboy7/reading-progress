<?php

declare(strict_types=1);

namespace Appto\Common\Domain\DateTime;

use Appto\Common\Domain\Exception\InvalidArgumentException;

class InvalidDateTimeException extends \DomainException implements InvalidArgumentException
{
    public function __construct(string $value)
    {
        parent::__construct("Invalid DateTime <$value>");
    }
}
