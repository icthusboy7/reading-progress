<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\View;

use Appto\Common\Domain\Criteria\SearchCriteria;

interface ReadingProgressViewRepository
{
    /**
     * @return ReadingProgressView[]
     */
    public function findByCriteria(SearchCriteria $criteria): array;

    public function get(string $id): ReadingProgressView;
}
