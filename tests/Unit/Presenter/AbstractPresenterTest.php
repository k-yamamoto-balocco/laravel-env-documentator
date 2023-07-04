<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Presenter;

use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use GitBalocco\LaravelEnvDocumentator\Presenter\AbstractPresenter;
use GitBalocco\LaravelEnvDocumentator\Presenter\PresenterInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Presenter\AbstractPresenter
 * @uses \GitBalocco\LaravelEnvDocumentator\Presenter\AbstractPresenter
 */
class AbstractPresenterTest extends TestCase
{

    /**
     * test___construct
     * @covers ::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___construct()
    {
        $table = \Mockery::mock(TableOfEnvItemsAndDestinations::class);
        $object = $this->createAnonymousConcreteClass($table);
        $this->assertInstanceOf(PresenterInterface::class, $object);
    }

    public function createAnonymousConcreteClass(TableOfEnvItemsAndDestinations $table): AbstractPresenter
    {
        return new class($table) extends AbstractPresenter {

        };
    }

    /**
     * @covers ::getTableOfEnvItemsAndDestinations
     */
    public function test_getTableOfEnvItemsAndDestinations()
    {
        $tableMock = \Mockery::mock(TableOfEnvItemsAndDestinations::class);
        $object = $this->createAnonymousConcreteClass($tableMock);

        \Closure::bind(
            function () use ($object, $tableMock) {
                //assertions
                $this->assertSame($tableMock, $object->getTableOfEnvItemsAndDestinations());
            },
            $this,
            $object
        )->__invoke();
    }
}