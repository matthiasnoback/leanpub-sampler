<?php

namespace Matthias\LeanpubSampler\Tests;

use Matthias\LeanpubSampler\FileLines;
use Matthias\LeanpubSampler\SampleTextLines;

class SampleTextLinesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_collects_chapters_and_parts()
    {
        $linesIterator = new FileLines(__DIR__ . '/fixtures/chapters-and-parts.txt');
        $sampleTextIterator = new SampleTextLines($linesIterator);

        $this->assertLinesReturnedByIteratorEqual(
            array(
                '-# Part 1',
                '',
                '# Chapter 1',
                '',
                '## Section 1',
                '',
                '-# Part 2',
                '',
                '# Chapter 2',
                '',
                '## Section 2',
                '',
            ),
            $sampleTextIterator
        );
    }

    /**
     * @test
     */
    public function it_collects_text_between_sample_comments()
    {
        $linesIterator = new FileLines(__DIR__ . '/fixtures/sample.txt');
        $sampleTextIterator = new SampleTextLines($linesIterator);

        $this->assertLinesReturnedByIteratorEqual(
            array(
                '',
                'Sample text',
                '',
                'More sample text',
                ''
            ),
            $sampleTextIterator
        );
    }

    private function assertLinesReturnedByIteratorEqual($expected, \Iterator $iterator)
    {
        $this->assertEquals($expected, iterator_to_array($iterator));
    }
}
