<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\UI\Rest;

use Appto\Common\Infrastructure\Symfony\UI\Rest\BaseController;
use Appto\ReadingProgress\Application\Command\FinishPlan;
use Appto\ReadingProgress\Application\Command\FinishPlanRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route(
 *     "/reading-progress", name="reading-progress_"
 * )
 */
class FinishPlanController extends BaseController
{
    /**
     * @Route(
     *     "/{id}/finish",
     *     methods={"PUT"},
     *     name="finish-plan"
     * )
     */
    public function __invoke(Request $request, string $id, FinishPlan $finishPlan)
    {
        $body = json_decode((string)$request->getContent());
        $this->ensureValid(['id' => $id, 'finishDate' => $body->finishDate], $this->constraint());

        $finishPlan(new FinishPlanRequest($id, $body->finishDate));

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    private function constraint(): Assert\Collection
    {
        $dateTimeConstraint = new Assert\DateTime();
        $dateTimeConstraint->format = \DateTimeInterface::ISO8601;

        return new Assert\Collection([
            'id' => new Assert\Required([new Assert\Uuid(), new Assert\NotNull()]),
            'finishDate' => new Assert\Required([new Assert\NotNull(), $dateTimeConstraint])
        ]);
    }
}
