<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\UI\Rest;

use Appto\Common\Infrastructure\Symfony\UI\Rest\BaseController;
use Appto\ReadingProgress\Application\Command\StartPlan;
use Appto\ReadingProgress\Application\Command\StartPlanRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route(
 *     "/reading-progress", name="reading-progress_"
 * )
 */
class StartPlanController extends BaseController
{
    /**
     * @Route(
     *     "/{id}/start",
     *     methods={"PUT"},
     *     name="start-plan"
     * )
     */
    public function __invoke(Request $request, string $id, StartPlan $startPlan)
    {
        $body = json_decode((string)$request->getContent());
        $this->ensureValid(['id' => $id, 'startDate' => $body->startDate], $this->constraint());

        $startPlan(new StartPlanRequest($id, $body->startDate));

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    private function constraint(): Assert\Collection
    {
        $dateTimeConstraint = new Assert\DateTime();
        $dateTimeConstraint->format = \DateTimeInterface::ISO8601;

        return new Assert\Collection([
            'id' => new Assert\Required([new Assert\Uuid(), new Assert\NotNull()]),
            'startDate' => new Assert\Required([new Assert\NotNull(), $dateTimeConstraint])
        ]);
    }
}
