<?php


namespace GitBalocco\LaravelEnvDocumentator\Config\Validator;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\RespectValidatorExceptionHandler;
use Respect\Validation\Validatable;

interface ValidatorInterface
{
    public function definition(): Validatable;

    public function getExceptionHandler(): ?RespectValidatorExceptionHandler;

}