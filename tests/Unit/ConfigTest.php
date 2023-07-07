<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit;

use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Path;
use GitBalocco\LaravelEnvDocumentator\Test\BaseTestCase;
use Illuminate\Support\Facades\Config as ConfigFacade;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config\Config
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Config
 * @uses \GitBalocco\LaravelEnvDocumentator\ServiceProvider
 * @uses \GitBalocco\LaravelEnvDocumentator\Decryption\Base64KeyParser
 */
class ConfigTest extends BaseTestCase
{
    /**
     * @covers ::__construct
     */
    public function test___construct()
    {
        $config = new Config();
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * @covers ::getDestinations
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getDestinations_defaultValue()
    {
        $config = new Config();
        $this->assertSame($config->getDestinations(), ['production', 'staging', 'develop', 'testing']);
    }

    /**
     * @covers ::getDestinations
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_Destinations()
    {
        ConfigFacade::set('env-documentator.destinations', ['hoge', 'piyo']);
        $config = new Config();
        $this->assertSame($config->getDestinations(), ['hoge', 'piyo']);
    }

    /**
     * @covers ::getPaths
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getPaths()
    {
        $paths = [
            'production' => '.env.production.encrypted',
            'staging' => '.env.staging.encrypted',
        ];
        ConfigFacade::set('env-documentator.paths', $paths);
        $config = new Config();
        $this->assertSame($paths, $config->getPaths());
    }

    /**
     * @covers ::getSecrets
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getSecrets()
    {
        $arraySecret = [
            'APP_ENV' => '***masked***',
        ];
        ConfigFacade::set('env-documentator.filters.secrets', $arraySecret);
        $config = new Config();
        $this->assertSame($arraySecret, $config->getSecrets());
    }

    /**
     * @covers ::getMetadataColumns
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getMetadataColumns()
    {
        $metaValues = [
            'title' => null,
            'description' => null,
            'laravels' => null,
        ];
        ConfigFacade::set('env-documentator.metadata', $metaValues);
        $config = new Config();
        $this->assertSame(['title', 'description', 'laravels'], $config->getMetadataColumns());
    }

    /**
     * @covers ::getMetadataValue
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getMetadataValue()
    {
        $metaValues = [
            'description' => [
                'APP_NAME' => 'アプリケーション名'
            ],
        ];
        ConfigFacade::set('env-documentator.metadata', $metaValues);
        $config = new Config();
        $this->assertSame(
            'アプリケーション名',
            $config->getMetadataValue('description', 'APP_NAME')
        );
    }

    /**
     * @covers ::getDefaultKey
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getDefaultKey()
    {
        $arrayConfig = [
            'default_key' => 'default-key-value',
        ];
        ConfigFacade::set('env-documentator', $arrayConfig);
        $config = new Config();
        $this->assertSame('default-key-value', $config->getDefaultKey());
    }

    /**
     * @covers ::getDefaultCipher
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getDefaultCipher()
    {
        $arrayConfig = [
            'default_cipher' => 'default-cipher-value',
        ];
        ConfigFacade::set('env-documentator', $arrayConfig);
        $config = new Config();
        $this->assertSame('default-cipher-value', $config->getDefaultCipher());
    }

    /**
     * @covers ::getIterator
     * @uses GitBalocco\LaravelEnvDocumentator\Config\Destination
     */
    public function test_getIterator()
    {
        ConfigFacade::set('env-documentator.destinations', ['destination01']);
        ConfigFacade::set('env-documentator.default_key', 'default-key');
        ConfigFacade::set('env-documentator.default_cipher', 'default-cipher');
        $config = new Config();
        foreach ($config->getIterator() as $destination) {
            $this->assertSame('destination01', $destination->getName());
            $this->assertSame('default-cipher', $destination->getCypher());
            $this->assertSame('.env.destination01.encrypted', $destination->getEncryptedFilePath());
            $this->assertSame('default-key', $destination->getEncryptionKey());
        }
    }

}