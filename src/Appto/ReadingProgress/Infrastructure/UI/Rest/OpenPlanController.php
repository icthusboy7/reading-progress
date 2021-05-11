<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\UI\Rest;

use Appto\Common\Infrastructure\Symfony\UI\Rest\BaseController;
use Appto\ReadingProgress\Application\Command\OpenPlan;
use Appto\ReadingProgress\Application\Command\OpenPlanRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route(
 *     "/reading-progress", name="reading-progress_"
 * )
 */
class OpenPlanController extends BaseController
{
    /**
     * @Route(
     *     "/{id}",
     *     methods={"PUT"},
     *     name="open-plan"
     * )
     */
    public function __invoke(Request $request, string $id, OpenPlan $openPlan)
    {
        $body = json_decode((string)$request->getContent());

        $this->ensureValid((array)$body, $this->constraint());

        if ($id != $body->id) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        $openPlan(new OpenPlanRequest(
            $body->id,
            $body->planId,
            $body->readerId,
            $body->openDate,
        ));

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    private function constraint(): Assert\Collection
    {
        $dateTimeConstraint = new Assert\DateTime();
        $dateTimeConstraint->format = \DateTimeInterface::ISO8601;

        return new Assert\Collection([
            'id' => new Assert\Required([new Assert\Uuid(), new Assert\NotNull()]),
            'planId' => new Assert\Required([new Assert\Uuid(), new Assert\NotNull()]),
            'readerId' => new Assert\Required([new Assert\Uuid(), new Assert\NotNull()]),
            'openDate' => new Assert\Required([new Assert\NotNull(), $dateTimeConstraint]),
        ]);
    }
}
