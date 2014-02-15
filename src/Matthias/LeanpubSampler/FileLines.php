<?php

namespace Matthias\LeanpubSampler;

class FileLines implements \Iterator
{
    private $line;
    private $handle;

    public function __construct($file)
    {
        $this->handle = fopen($file, 'r');
    }

    public function valid()
    {
        return !feof($this->handle);
    }

    public function next()
    {
        $this->line++;
    }

    public function current()
    {
        return rtrim(fgets($this->handle), "\n");
    }

    public function key()
    {
        return $this->line;
    }

    public function rewind()
    {
        $this->line = 0;
        fseek($this->handle, 0);
    }
}
