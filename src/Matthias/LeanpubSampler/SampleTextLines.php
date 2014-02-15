<?php

namespace Matthias\LeanpubSampler;

class SampleTextLines extends \FilterIterator implements \RecursiveIterator
{
    const BEGIN_SAMPLE_MARKER = '%% begin sample';
    const END_SAMPLE_MARKER = '%% end sample';

    private $line;
    private $isSampleText;
    private $addAllSectionMarkers;

    public function __construct(\Traversable $lines, $addAllSectionMarkers = true)
    {
        $this->addAllSectionMarkers = $addAllSectionMarkers;

        parent::__construct(new \IteratorIterator($lines));
    }

    public function accept()
    {
        $currentLine = parent::current();

        if (substr($currentLine, 0, 15) === self::BEGIN_SAMPLE_MARKER) {
            $this->isSampleText = true;

            return false;
        }

        if (substr($currentLine, 0, 13) === self::END_SAMPLE_MARKER) {
            $this->isSampleText = false;

            return false;
        }

        if ($this->isSampleText) {
            return true;
        }

        if ($this->addAllSectionMarkers && $this->lineIsSectionMarker($currentLine)) {
            return true;
        }

        return false;
    }

    public function key()
    {
        return $this->line;
    }

    public function next()
    {
        parent::next();
        $this->line++;
    }

    public function rewind()
    {
        parent::rewind();
        $this->line = 0;
    }

    public function hasChildren()
    {
        return false;
    }

    public function getChildren()
    {
        return false;
    }

    private function lineIsSectionMarker($line)
    {
        if (substr($line, 0, 1) === '#') {
            // regular chapter, section, subsection, etc.
            return true;
        }

        if (substr($line, 0, 2) === '-#') {
            // part
            return true;
        }

        return false;
    }
}
