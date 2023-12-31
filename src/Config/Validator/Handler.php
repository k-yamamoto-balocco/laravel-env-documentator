<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config\Validator;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CiphersValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CipherValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultCipherValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DestinationValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\KeysValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\PathsValidator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config as ConfigFacade;

class Handler
{
    /** @var Collection<ValidatorInterface> $validators */
    private Collection $validators;
    private array $messages;

    public function __construct()
    {
        $this->messages = [];
        $this->validators = new Collection();

        $this->validators->put(
            'default_key',
            new DefaultKeyValidator(ConfigFacade::get('env-documentator.default_key'))
        );
        $this->validators->put(
            'default_cipher',
            new DefaultCipherValidator(
                new CipherValidator(),
                ConfigFacade::get('env-documentator.default_cipher')
            )
        );

        $this->validators->put(
            'destinations',
            new DestinationValidator(ConfigFacade::get('env-documentator.destinations'))
        );

        $this->validators->put(
            'paths',
            new PathsValidator(
                ConfigFacade::get('env-documentator.destinations'),
                ConfigFacade::get('env-documentator.paths')
            )
        );
        $this->validators->put(
            'keys',
            new KeysValidator(
                ConfigFacade::get('env-documentator.destinations'),
                ConfigFacade::get('env-documentator.keys')
            )
        );
        $this->validators->put(
            'ciphers',
            new CiphersValidator(
                new CipherValidator(),
                ConfigFacade::get('env-documentator.destinations'),
                ConfigFacade::get('env-documentator.ciphers')
            )
        );
    }

    public function __invoke(): bool
    {
        $result = true;
        $messages = [];
        foreach ($this->validators as $configName => $validator) {
            if (false === $validator->__invoke()) {
                $result = false;
            }
            $exceptionHandler = $validator->getExceptionHandler();
            if (!is_null($exceptionHandler)) {
                $messages[$configName] = $exceptionHandler->getMessages();
            }
        }
        $this->messages = $messages;
        return $result;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
