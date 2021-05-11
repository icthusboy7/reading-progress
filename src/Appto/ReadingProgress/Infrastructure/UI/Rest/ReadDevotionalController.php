<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\UI\Rest;

use Appto\Common\Infrastructure\Symfony\UI\Rest\BaseController;
use Appto\ReadingProgress\Application\Command\ReadDevotional;
use Appto\ReadingProgress\Application\Command\ReadDevotionalRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route(
 *     "/reading-progress", name="reading-progress_"
 * )
 */
class ReadDevotionalController extends BaseController
{
    /**
     * @Route(
     *     "/{id}/devotionals/{devotionalId}/read",
     *     methods={"PUT"},
     *     name="readDevotional"
     * )
     */
    public function __invoke(Request $request, string $id, string $devotionalId, ReadDevotional $readDevotional)
    {
        $body = json_decode((string)$request->getContent());

        $this->ensureValid(
            [
                'id' => $id,
                'devotionalId' => $devotionalId,
                'readDate' => $body->readDate
            ],
            $this->constraint()
        );

        $readDevotional(new ReadDevotionalRequest(
            $id,
            $devotionalId,
            $body->readDate
        ));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function constraint(): Assert\Collection
    {
        $dateTimeConstraint = new Assert\DateTime();
        $dateTimeConstraint->format = \DateTimeInterface::ISO8601;

        return new Assert\Collection([
            'id' => new Assert\Required([new Assert\Uuid(), new Assert\NotNull()]),
            'devotionalId' => new Assert\Required([new Assert\Uuid(), new Assert\NotNull()]),
            'readDate' => new Assert\Required([new Assert\NotNull(), $dateTimeConstraint]),
        ]);
    }
}
