<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Application\Query;

use Appto\Common\Application\Query\QueryHandler;
use Appto\ReadingProgress\View\ReadingProgressView;
use Appto\ReadingProgress\View\ReadingProgressViewRepository;

class GetReadingProgress implements QueryHandler
{
    private ReadingProgressViewRepository $repository;

    public function __construct(ReadingProgressViewRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetReadingProgressRequest $query): ReadingProgressView
    {
        return $this->repository->get($query->id());
    }
}
