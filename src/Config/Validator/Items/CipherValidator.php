<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\ValidatorInterface;
use Respect\Validation\Validatable;
use Respect\Validation\Validator as v;

class CipherValidator extends BaseValidator implements ValidatorInterface
{
    /**
     * @return Validatable
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function definition(): Validatable
    {
        return v::in(['aes-128-cbc', 'aes-256-cbc', 'aes-128-gcm', 'aes-256-gcm']);
    }
}
