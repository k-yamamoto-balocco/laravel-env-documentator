<?php


namespace GitBalocco\LaravelEnvDocumentator\Config\Validator;

use Respect\Validation\Validatable;

interface ValidatorInterface
{
    public function definition(): Validatable;
    public function getMessage(): string;

}