<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\Persistence\ReadModel\Doctrine;

use Appto\Common\Domain\Criteria\Filter;
use Appto\Common\Domain\Criteria\SearchCriteria;
use Appto\ReadingProgress\Domain\ReadingProgress;
use Appto\ReadingProgress\Domain\ReadingProgressNotFoundException;
use Appto\ReadingProgress\Infrastructure\Persistence\ReadModel\Doctrine\Entity\ReadingProgressEntityViewRepository;
use Appto\ReadingProgress\View\ReadingProgressView;
use Appto\ReadingProgress\View\ReadingProgressViewAssembler;
use Appto\ReadingProgress\View\ReadingProgressViewRepository;

class DoctrineReadingProgressViewRepository implements ReadingProgressViewRepository
{
    private ReadingProgressEntityViewRepository $repository;
    private ReadingProgressViewAssembler $readingProgressViewAssembler;

    public function __construct(
        ReadingProgressEntityViewRepository $doctrineRepository,
        ReadingProgressViewAssembler $readingProgressViewAssembler
    ) {
        $this->repository = $doctrineRepository;
        $this->readingProgressViewAssembler = $readingProgressViewAssembler;
    }

    /**
     * @return ReadingProgressView[]
     */
    public function findByCriteria(SearchCriteria $criteria): array
    {
        $doctrineFilters = [];
        foreach ($criteria->filters() as $filter) {
            $doctrineFilters[$filter->name() . '.value'] = $filter->value();
        }

        $readingProgresses = $this->repository->findBy($doctrineFilters);

        return array_map(
            fn(ReadingProgress $readingProgress) => $this->readingProgressViewAssembler->assemble($readingProgress),
            $readingProgresses
        );
    }

    public function get(string $id): ReadingProgressView
    {
        $readingProgress = $this->repository->find($id);

        if (!$readingProgress) {
            throw new ReadingProgressNotFoundException($id);
        }

        return $this->readingProgressViewAssembler->assemble($readingProgress);
    }
}
