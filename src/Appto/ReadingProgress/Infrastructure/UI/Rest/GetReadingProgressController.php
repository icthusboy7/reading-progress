<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\UI\Rest;

use Appto\Common\Infrastructure\Symfony\UI\Rest\BaseController;
use Appto\ReadingProgress\Application\Query\GetReadingProgress;
use Appto\ReadingProgress\Application\Query\GetReadingProgressRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route(
 *     "/reading-progress", name="reading-progress_"
 * )
 */
class GetReadingProgressController extends BaseController
{
    /**
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="get-reading-progress"
     * )
     */
    public function __invoke(string $id, GetReadingProgress $getReadingProgress)
    {
        $this->ensureValid(['id' => $id], $this->constraint());

        return new JsonResponse($getReadingProgress(new GetReadingProgressRequest($id)), Response::HTTP_OK);
    }

    private function constraint(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => new Assert\Required([new Assert\Uuid(), new Assert\NotNull()])
        ]);
    }
}
