<?php

namespace Matthias\LeanpubSampler;

class SampleTextLinesFactory
{
    private $addAllSectionMarkers;

    public function __construct($addAllSectionMarkers)
    {
        $this->addAllSectionMarkers = $addAllSectionMarkers;
    }

    public function createForFile($file)
    {
        return new SampleTextLines(new FileLines($file), $this->addAllSectionMarkers);
    }
}
