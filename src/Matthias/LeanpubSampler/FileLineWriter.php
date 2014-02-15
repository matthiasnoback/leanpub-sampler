<?php

namespace Matthias\LeanpubSampler;

class FileLineWriter
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function writeLines(\Traversable $lines)
    {
        $handle = fopen($this->file, 'w+');

        foreach ($lines as $line) {
            fputs($handle, $line."\n");
        }

        fclose($handle);
    }
}
