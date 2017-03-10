<?php
declare(strict_types = 1);

namespace Matthias\LeanpubSampler;

final class FileLines implements \Iterator
{
    private $line;
    private $handle;

    public function __construct($file)
    {
        $this->handle = fopen($file, 'r');
    }

    public function valid(): bool
    {
        return !feof($this->handle);
    }

    public function next(): void
    {
        $this->line++;
    }

    public function current(): string
    {
        return rtrim((string)fgets($this->handle), "\n");
    }

    public function key(): int
    {
        return $this->line;
    }

    public function rewind(): void
    {
        $this->line = 0;
        fseek($this->handle, 0);
    }
}
