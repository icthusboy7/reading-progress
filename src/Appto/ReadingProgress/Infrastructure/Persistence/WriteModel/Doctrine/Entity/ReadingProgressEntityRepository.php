<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\Persistence\WriteModel\Doctrine\Entity;

use Appto\ReadingProgress\Domain\ReadingProgress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReadingProgressEntityRepository extends ServiceEntityRepository
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        parent::__construct($registry, ReadingProgress::class);
    }

    public function save(ReadingProgress $readingProgress): void
    {
        $this->getEntityManager()->persist($readingProgress);
        $this->getEntityManager()->flush();
    }
}
