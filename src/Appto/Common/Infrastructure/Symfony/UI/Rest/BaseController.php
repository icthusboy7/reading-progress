<?php

declare(strict_types=1);

namespace Appto\Common\Infrastructure\Symfony\UI\Rest;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

abstract class BaseController
{
    private $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    protected function ensureValid(array $data, Assert\Collection $constraint): void
    {
        $validation = $this->validator->validate($data, $constraint);

        if (count($validation) > 0) {
            $errors = $validation->get(0)->getMessage();
            throw new BadRequestHttpException($errors);
        }
    }
}
