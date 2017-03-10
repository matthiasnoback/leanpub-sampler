<?php
declare(strict_types = 1);

namespace Matthias\LeanpubSampler;

final class SampleTextLinesFactory
{
    private $addAllSectionMarkers;

    public function __construct(bool $addAllSectionMarkers)
    {
        $this->addAllSectionMarkers = $addAllSectionMarkers;
    }

    public function createForFile(string $file): SampleTextLines
    {
        return new SampleTextLines(new FileLines($file), $this->addAllSectionMarkers);
    }
}
