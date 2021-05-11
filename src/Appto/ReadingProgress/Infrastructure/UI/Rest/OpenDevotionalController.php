<?php

declare(strict_types=1);

namespace Appto\ReadingProgress\Infrastructure\UI\Rest;

use Appto\Common\Infrastructure\Symfony\UI\Rest\BaseController;
use Appto\ReadingProgress\Application\Command\OpenDevotional;
use Appto\ReadingProgress\Application\Command\OpenDevotionalRequest;
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
class OpenDevotionalController extends BaseController
{
    /**
     * @Route(
     *     "/{id}/devotionals/{devotionalId}/open",
     *     methods={"PUT"},
     *     name="openDevotional"
     * )
     */
    public function __invoke(Request $request, string $id, string $devotionalId, OpenDevotional $openDevotional)
    {
        $body = json_decode((string)$request->getContent());

        $this->ensureValid(
            [
                'id' => $id,
                'devotionalId' => $devotionalId,
                'openDate' => $body->openDate
            ],
            $this->constraint()
        );

        $openDevotional(new OpenDevotionalRequest(
            $id,
            $devotionalId,
            $body->openDate
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
            'openDate' => new Assert\Required([new Assert\NotNull(), $dateTimeConstraint]),
        ]);
    }
}
