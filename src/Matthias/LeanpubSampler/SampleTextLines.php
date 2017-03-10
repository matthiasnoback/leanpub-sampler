<?php
declare(strict_types = 1);

namespace Matthias\LeanpubSampler;

final class SampleTextLines extends \FilterIterator implements \RecursiveIterator
{
    const BEGIN_SAMPLE_MARKER = '%% begin sample';
    const END_SAMPLE_MARKER = '%% end sample';

    private $line;
    private $isSampleText;
    private $addAllSectionMarkers;
    private $previousLineWasSectionMarker;

    public function __construct(\Traversable $lines, bool $addAllSectionMarkers = true)
    {
        $this->addAllSectionMarkers = $addAllSectionMarkers;

        parent::__construct(new \IteratorIterator($lines));
    }

    public function accept(): bool
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

        if ($this->addAllSectionMarkers) {
            if ($this->lineIsSectionMarker($currentLine)) {
                $this->previousLineWasSectionMarker = true;

                return true;
            }

            if ($this->previousLineWasSectionMarker) {
                $this->previousLineWasSectionMarker = false;

                return true;
            }
        }

        return false;
    }

    public function key(): int
    {
        return $this->line;
    }

    public function next(): void
    {
        parent::next();
        $this->line++;
    }

    public function rewind(): void
    {
        parent::rewind();
        $this->line = 0;
    }

    public function hasChildren(): bool
    {
        return false;
    }

    public function getChildren(): \Iterator
    {
        throw new \LogicException('Not implemented');
    }

    private function lineIsSectionMarker(string $line): bool
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
