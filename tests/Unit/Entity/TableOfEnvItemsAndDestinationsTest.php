<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Entity;

use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations
 */
class TableOfEnvItemsAndDestinationsTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::initItemNames
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___construct()
    {
        $object = new TableOfEnvItemsAndDestinations(['dest01' => []]);
        $this->assertInstanceOf(TableOfEnvItemsAndDestinations::class, $object);
    }

    /**
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::__construct
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::initItemNames
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::table
     * @covers ::getIterator
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getIterator()
    {
        $testCase = [
            'dest01' => ['APP_URL' => 'http://domain.name.one'],
        ];
        $object = new TableOfEnvItemsAndDestinations($testCase);
        foreach ($object as $key => $item) {
            $this->assertSame('dest01', $key);
            $this->assertSame(['APP_URL' => 'http://domain.name.one'], $item);
        }
    }

    /**
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::__construct
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::initItemNames
     * @covers ::getDestinations
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getDestinations()
    {
        $testCase = [
            'dest01' => [],
            'dest02' => [],
            'dest03' => [],
        ];
        $object = new TableOfEnvItemsAndDestinations($testCase);
        $this->assertSame(['dest01', 'dest02', 'dest03'], $object->getDestinations());
    }

    /**
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::__construct
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::initItemNames
     * @covers ::getEnvItemNames
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getEnvItemNames()
    {
        $testCase = [
            'dest01' => ['key01' => 101],
            'dest02' => ['key02' => 201, 'key03' => 202],
            'dest03' => ['key03' => 301, 'key04' => 302],
        ];
        $object = new TableOfEnvItemsAndDestinations($testCase);
        $this->assertSame(['key01', 'key02', 'key03', 'key04'], $object->getEnvItemNames());
    }

    /**
     * @covers ::table
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::__construct
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::initItemNames
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::getEnvItemNames
     * @uses \GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations::getDestinations
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_table()
    {
        $testCase = [
            'dest01' => ['key01' => 101],
            'dest02' => ['key02' => 201, 'key03' => 202],
            'dest03' => ['key03' => 301, 'key04' => 302],
        ];
        $object = new TableOfEnvItemsAndDestinations($testCase);
        $this->assertSame([
            'dest01' => [
                'key01' => 101,
                'key02' => null,
                'key03' => null,
                'key04' => null
            ],
            'dest02' => [
                'key01' => null,
                'key02' => 201,
                'key03' => 202,
                'key04' => null
            ],
            'dest03' => [
                'key01' => null,
                'key02' => null,
                'key03' => 301,
                'key04' => 302
            ],

        ], $object->table());
    }
}