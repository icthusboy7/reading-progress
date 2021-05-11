<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\Persistence\WriteModel\Doctrine;

use Appto\ReadingProgress\Domain\ReadingProgress;
use Appto\ReadingProgress\Domain\ReadingProgressNotFoundException;
use Appto\ReadingProgress\Domain\ReadingProgressRepository;
use Appto\ReadingProgress\Infrastructure\Persistence\WriteModel\Doctrine\Entity\ReadingProgressEntityRepository;

class DoctrineReadingProgressRepository implements ReadingProgressRepository
{
    private ReadingProgressEntityRepository $repository;

    public function __construct(ReadingProgressEntityRepository $doctrineRepository)
    {
        $this->repository = $doctrineRepository;
    }

    public function get(string $readingProgressId): ReadingProgress
    {
        /** @var null|ReadingProgress $readingProgress */
        $readingProgress = $this->repository->find($readingProgressId);
        if (!$readingProgress) {
            throw new ReadingProgressNotFoundException($readingProgressId);
        }
        return $readingProgress;
    }

    public function find(string $readingProgressId): ?ReadingProgress
    {
        /** @var null|ReadingProgress $readingProgress */
        $readingProgress = $this->repository->find($readingProgressId);
        return $readingProgress;
    }

    public function findBy(string $planId, string $readerId): ?ReadingProgress
    {
        /** @var null|ReadingProgress $readingProgress */
        $readingProgress = $this->repository->findOneBy(['planId.value' => $planId, 'readerId.value' => $readerId]);
        return $readingProgress;
    }

    public function save(ReadingProgress $readingProgress): void
    {
        $this->repository->save($readingProgress);
    }
}
