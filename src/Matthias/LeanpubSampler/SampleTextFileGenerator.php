<?php
declare(strict_types = 1);

namespace Matthias\LeanpubSampler;

final class SampleTextFileGenerator
{
    private $manuscriptDirectory;
    private $filename;
    private $addAllSectionMarkers;
    /**
     * @var bool
     */
    private $fromSubset;

    public function __construct(
        string $manuscriptDirectory,
        bool $fromSubset,
        string $filename,
        bool $addAllSectionMarkers
    ) {
        $this->manuscriptDirectory = $manuscriptDirectory;
        $this->filename = $filename;
        $this->addAllSectionMarkers = $addAllSectionMarkers;
        $this->fromSubset = $fromSubset;
    }

    public function generate() : void
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

    protected function createFileTraversable() : \Traversable
    {
        $includeManuscriptFilesFrom = rtrim($this->manuscriptDirectory, '/') . '/' . ($this->fromSubset ? 'Subset.txt' : 'Book.txt');
        if (!is_file($includeManuscriptFilesFrom)) {
            throw new \RuntimeException('File not found: ' . $includeManuscriptFilesFrom);
        }

        $bookTxtLines = array_filter(
            file($includeManuscriptFilesFrom, FILE_IGNORE_NEW_LINES),
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
