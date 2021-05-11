<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Domain;

interface ReadingProgressRepository
{
    public function get(string $readingProgressId): ReadingProgress;
    public function find(string $readingProgressId): ?ReadingProgress;
    public function findBy(string $planId, string $readerId): ?ReadingProgress;
    public function save(ReadingProgress $readingProgress): void;
}
