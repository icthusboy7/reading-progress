<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Query;

use Appto\Common\Application\Query\QueryHandler;
use Appto\Common\Domain\Criteria\Filter;
use Appto\Common\Domain\Criteria\SearchCriteria;
use Appto\ReadingProgress\View\ReadingProgressView;
use Appto\ReadingProgress\View\ReadingProgressViewRepository;

class ListReadingProgress implements QueryHandler
{
    private ReadingProgressViewRepository $repository;

    public function __construct(ReadingProgressViewRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ReadingProgressView[]
     */
    public function __invoke(ListReadingProgressRequest $query): array
    {
        return $this->repository->findByCriteria($this->buildSearchCriteria($query));
    }

    private function buildSearchCriteria(ListReadingProgressRequest $query): SearchCriteria
    {
        $criteria = new SearchCriteria();

        if ($query->planId()) {
            $criteria->add(new Filter('planId', '=', $query->planId()));
        }

        if ($query->readerId()) {
            $criteria->add(new Filter('readerId', '=', $query->readerId()));
        }

        return $criteria;
    }
}
