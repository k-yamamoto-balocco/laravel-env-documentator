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
    private Collection $table;

    public function __construct(array $decrypted)
    {
        //内部的にはCollectionにしておいて、取り出し方をpublicメソッドで決めてやる
        $collection = new Collection($decrypted);
        $this->collection = $collection;
        $this->destinations = $collection->keys()->toArray();
        $this->envItemNames = $this->initItemNames($this->collection);
        $this->table = $this->initTable($this->destinations, $this->envItemNames);
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
     * @return Collection
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function table(): Collection
    {
        //全体の結果を初期化
        $result = [];
        foreach ($this->destinations as $destination) {
            //各デプロイ環境ごとの内容初期化
            $result[$destination] = [];
            foreach ($this->envItemNames as $itemName) {
                $result[$destination][$itemName] = $this->collection->get($destination)[$itemName] ?? null;
            }
        }
        return new Collection($result);
    }

    public function hoge()
    {
        $collection = new Collection ($this->table());
        foreach ($this->envItemNames as $itemName) {
            yield $itemName => $collection->pluck($itemName);
        }
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

    private function initTable($destinations, $envItemNames): Collection
    {
        //全体の結果を初期化
        $result = [];
        foreach ($destinations as $destination) {
            //各デプロイ環境ごとの内容初期化
            $result[$destination] = [];
            foreach ($envItemNames as $itemName) {
                $result[$destination][$itemName] = $this->collection->get($destination)[$itemName] ?? null;
            }
        }
        return new Collection($result);
    }

    /**
     * @return Collection
     */
    public function getTable(): Collection
    {
        return $this->table;
    }


}
