<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Feature\Command;

use GitBalocco\LaravelEnvDocumentator\Test\Feature\FeatureTestCase;
use Illuminate\Support\Facades\Config as ConfigFacade;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Command\EnvDocumentatorCommand
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Handler
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CipherValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CiphersValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultCipherValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DestinationValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\KeysValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\PathsValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\RespectValidatorExceptionHandler
 * @uses GitBalocco\LaravelEnvDocumentator\ServiceProvider
 * @uses GitBalocco\LaravelEnvDocumentator\Command\CommandParameters\MetadataOption
 * @uses GitBalocco\LaravelEnvDocumentator\Command\EnvDocumentatorCommand
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Config
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Destination
 * @uses GitBalocco\LaravelEnvDocumentator\Decryption\Base64KeyParser
 * @uses GitBalocco\LaravelEnvDocumentator\Decryption\Handler
 * @uses GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations
 * @uses GitBalocco\LaravelEnvDocumentator\Presenter\AbstractConverter
 * @uses GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultConverter
 * @uses GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultPresenter
 * @uses GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\Handler
 * @uses GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\SecretFilter
 */
class EnvDocumentatorCommandTest extends FeatureTestCase
{
    /**
     * test_失敗
     * デフォルト状態で実行した場合、default_keyが指定されていない状態のため失敗する。
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @covers ::handle
     */
    public function test_失敗()
    {
        $actual = $this->artisan('env:documentator');
        $actual->assertFailed();
        $actual->expectsOutput('invalid configuration in:"default_key"');
    }

    /**
     * @covers ::handle
     * @covers ::decidePresenter
     * キーの問題で復号に失敗する。正常系とほぼ同等。
     */
    public function test_復号失敗()
    {
        ConfigFacade::set('env-documentator.default_key', 'aa');
        $actual = $this->artisan('env:documentator');
        $actual->assertOk();
    }
}