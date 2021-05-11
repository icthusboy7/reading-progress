<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Query;

use Appto\Common\Application\Query\Query;

class GetReadingProgressRequest implements Query
{
    private string $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
