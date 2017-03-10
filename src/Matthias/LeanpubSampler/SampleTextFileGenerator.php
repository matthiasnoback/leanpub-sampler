<?php

namespace Matthias\LeanpubSampler;

use Symfony\Component\Finder\Finder;

class SampleTextFileGenerator
{
    private $manuscriptDirectory;
    private $filename;
    private $addAllSectionMarkers;

    public function __construct(
        $manuscriptDirectory,
        $filename,
        $addAllSectionMarkers
    ) {
        $this->manuscriptDirectory = $manuscriptDirectory;
        $this->filename = $filename;
        $this->addAllSectionMarkers = $addAllSectionMarkers;
    }

    public function generate()
    {
        $fileTraversable = $this->createFileTraversable();

        $sampleTextIteratorFactory = new SampleTextLinesFactory($this->addAllSectionMarkers);

        $manuscriptLines = new \RecursiveIteratorIterator(
            new ManuscriptLines(
                $fileTraversable,
                $sampleTextIteratorFactory
            )
        );

        $writer = new FileLineWriter($this->filename);
        $writer->writeLines($manuscriptLines);
    }

    protected function createFileTraversable()
    {
        $bookTxtLines = array_filter(
            file($this->manuscriptDirectory . '/Book.txt', FILE_IGNORE_NEW_LINES),
            function ($line) {
                return trim($line) !== '';
            }
        );
        $manuscriptFiles = array_map(function($relativePath) {
            return $this->manuscriptDirectory . '/' . $relativePath;
        }, $bookTxtLines);

        return new \ArrayIterator($manuscriptFiles);
    }
}
