<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Command\CommandParameters;

use GitBalocco\LaravelEnvDocumentator\Command\CommandParameters\MetadataOption;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Command\CommandParameters\MetadataOption
 * @uses \GitBalocco\LaravelEnvDocumentator\Command\CommandParameters\MetadataOption
 */
class MetadataOptionTest extends TestCase
{
    static public function dataProvider(): array
    {
        return [
            "オプション入力値がnullの場合、空配列" => [
                null,
                ["description", "laravels", "url"],
                []
            ],
            "オプション入力値が'all'の場合そのまま返却" => [
                "all",
                ["description", "laravels", "url"],
                ["description", "laravels", "url"]
            ],
            "オプション入力値が文字列の場合、１つだけ返却" => [
                "description",
                ["description", "laravels", "url"],
                ["description"]
            ],
            "オプション入力値にカンマ区切りで複数指定" => [
                "description,laravels",
                ["description", "laravels", "url"],
                ["description", "laravels"]
            ],
            "オプション入力値の順序を変えた場合、入力順に返却" => [
                "url,description",
                ["description", "laravels", "url"],
                ["url", "description"]
            ],
        ];
    }

    /**
     * @covers ::__construct
     *
     */
    public function test___construct()
    {
        $option = new MetadataOption('input-string', ['metaColumn' => 'value01']);

        \Closure::bind(
            function () use ($option) {
                //assertions
                $this->assertSame('input-string', $option->input);
                $this->assertSame(['metaColumn' => 'value01'], $option->configMetadataColumns);
            },
            $this,
            $option
        )->__invoke();
    }

    /**
     * test_visibleMetadataColumns
     *
     * @param $argInput
     * @param array $configMetadataColumns
     * @param array $expectation
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @dataProvider dataProvider
     * @covers ::visibleMetadataColumns
     */
    public function test_visibleMetadataColumns($argInput, array $configMetadataColumns, array $expectation)
    {
        $option = new MetadataOption($argInput, $configMetadataColumns);
        $actual = $option->visibleMetadataColumns();
        $this->assertSame($expectation, $actual);
    }
}