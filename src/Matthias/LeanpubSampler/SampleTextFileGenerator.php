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
        return Finder::create()
            ->in($this->manuscriptDirectory)
            ->files()
            ->name('*.md')->name('*.txt')
            ->notName(basename($this->filename))
            ->sortByName();
    }
}
