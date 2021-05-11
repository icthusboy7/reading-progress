<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\Persistence\ReadModel\Doctrine\Entity;

use Appto\ReadingProgress\Domain\ReadingProgress;
use Appto\ReadingProgress\View\ReadingProgressView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\FetchMode;

class ReadingProgressEntityViewRepository extends ServiceEntityRepository
{
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        parent::__construct($registry, ReadingProgress::class);
    }
}
