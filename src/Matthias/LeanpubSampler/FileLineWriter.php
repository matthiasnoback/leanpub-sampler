<?php
declare(strict_types = 1);

namespace Matthias\LeanpubSampler;

final class FileLineWriter
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function writeLines(\Traversable $lines): void
    {
        $handle = fopen($this->file, 'w+');

        foreach ($lines as $line) {
            fputs($handle, $line . "\n");
        }

        fclose($handle);
    }
}
