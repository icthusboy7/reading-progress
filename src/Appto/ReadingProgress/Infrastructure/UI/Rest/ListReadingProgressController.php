<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\UI\Rest;

use Appto\Common\Infrastructure\Symfony\UI\Rest\BaseController;
use Appto\ReadingProgress\Application\Query\ListReadingProgress;
use Appto\ReadingProgress\Application\Query\ListReadingProgressRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route(
 *     "/reading-progress", name="reading-progress_"
 * )
 */
class ListReadingProgressController extends BaseController
{
    /**
     * @Route(
     *     "",
     *     methods={"GET"},
     *     name="list-reading-progress"
     * )
     */
    public function __invoke(Request $request, ListReadingProgress $listReadingProgress)
    {
        $this->ensureValid($request->query->all(), $this->constraint());

        $planId = $request->query->get('planId');
        $readerId = $request->query->get('readerId');

        return new JsonResponse(
            $listReadingProgress(new ListReadingProgressRequest($planId, $readerId)),
            Response::HTTP_OK
        );
    }

    protected function constraint(): Assert\Collection
    {
        return new Assert\Collection([
            'planId' => new Assert\Optional(new Assert\Uuid()),
            'readerId' => new Assert\Optional(new Assert\Uuid()),
        ]);
    }
}
