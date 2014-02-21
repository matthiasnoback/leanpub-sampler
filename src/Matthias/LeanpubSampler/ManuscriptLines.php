<?php

namespace Matthias\LeanpubSampler;

class ManuscriptLines implements \RecursiveIterator
{
    private $fileIterator;
    private $iteratorFactory;

    public function __construct(\Traversable $fileTraversable, SampleTextLinesFactory $iteratorFactory)
    {
        $this->fileIterator = new \IteratorIterator($fileTraversable);
        $this->iteratorFactory = $iteratorFactory;
    }

    public function current()
    {
        return $this->fileIterator->current();
    }

    public function next()
    {
        $this->fileIterator->next();
    }

    public function key()
    {
        return $this->fileIterator->key();
    }

    public function valid()
    {
        return $this->fileIterator->valid();
    }

    public function rewind()
    {
        $this->fileIterator->rewind();
    }

    public function hasChildren()
    {
        return true;
    }

    public function getChildren()
    {
        return $this->iteratorFactory->createForFile($this->current());
    }
}
