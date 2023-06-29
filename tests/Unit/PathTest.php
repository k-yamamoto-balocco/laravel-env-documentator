<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit;

use GitBalocco\LaravelEnvDocumentator\Path;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Path
 */
class PathTest extends TestCase
{
    /**
     * test___construct
     * @covers ::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___construct()
    {
        $path = new Path();
        //エラーなくコンストラクタが成功することの検証
        $this->assertInstanceOf(Path::class, $path);
    }

    /**
     * test_getPackageRoot
     * @covers ::getPackageRoot
     * @uses \GitBalocco\LaravelEnvDocumentator\Path::__construct()
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getPackageRoot()
    {
        $path = new Path();
        $this->assertSame(realpath(__DIR__ . '/../../'), $path->getPackageRoot());
    }
}