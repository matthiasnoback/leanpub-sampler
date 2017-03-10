<?php
declare(strict_types = 1);

namespace Matthias\LeanpubSampler;

final class ManuscriptLines implements \RecursiveIterator
{
    private $fileIterator;
    private $iteratorFactory;

    public function __construct(\Traversable $fileTraversable, SampleTextLinesFactory $iteratorFactory)
    {
        $this->fileIterator = new \IteratorIterator($fileTraversable);
        $this->iteratorFactory = $iteratorFactory;
    }

    public function current(): string
    {
        return $this->fileIterator->current();
    }

    public function next(): void
    {
        $this->fileIterator->next();
    }

    public function key(): int
    {
        return $this->fileIterator->key();
    }

    public function valid(): bool
    {
        return $this->fileIterator->valid();
    }

    public function rewind(): void
    {
        $this->fileIterator->rewind();
    }

    public function hasChildren(): bool
    {
        return true;
    }

    public function getChildren(): \Iterator
    {
        return $this->iteratorFactory->createForFile($this->current());
    }
}
