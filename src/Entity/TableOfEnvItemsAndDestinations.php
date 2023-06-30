<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Entity;

use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;
use Traversable;

class TableOfEnvItemsAndDestinations implements IteratorAggregate
{
    private Collection $collection;
    /** @var string[] */
    private array $envItemNames;
    /** @var string[] */
    private array $destinations;

    public function __construct(array $decrypted)
    {
        //内部的にはCollectionにしておいて、取り出し方をpublicメソッドで決めてやる
        $collection = new Collection($decrypted);
        $this->collection = $collection;
        $this->destinations = $collection->keys()->toArray();
        $this->envItemNames = $this->initItemNames($this->collection);
    }

    /**
     * getIterator
     *
     * @return Traversable
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->table());
    }

    /**
     * table
     *
     * @return array[]
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function table(): array
    {
        $result = [];
        foreach ($this->destinations as $destination) {
            foreach ($this->envItemNames as $itemName) {
                $result[$destination][$itemName] = $this->collection->get($destination)[$itemName] ?? null;
            }
        }
        return $result;
    }

    /**
     * @return string[]
     */
    public function getEnvItemNames(): array
    {
        return $this->envItemNames;
    }

    /**
     * @return string[]
     */
    public function getDestinations(): array
    {
        return $this->destinations;
    }

    private function initItemNames(Collection $argCollection): array
    {
        $tmpMergedArray = [];
        foreach ($argCollection as $items) {
            $tmpMergedArray = array_merge($tmpMergedArray, $items);
        }
        return array_keys($tmpMergedArray);
    }
}
