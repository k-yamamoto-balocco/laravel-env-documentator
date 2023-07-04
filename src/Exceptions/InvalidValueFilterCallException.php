<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Exceptions;

use League\CommonMark\Exception\LogicException;

class InvalidValueFilterCallException extends LogicException
{
    #[Pure] public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if ($message === '') {
            $message = 'key and value should be validated.';
        }
        parent::__construct($message, $code, $previous);
    }

}