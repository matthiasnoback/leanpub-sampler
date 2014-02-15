<?php

namespace Matthias\LeanpubSampler\Tests;

use Matthias\LeanpubSampler\FileLines;

class FileLinesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_reads_lines_from_a_file_and_trims_new_line_characters()
    {
        $iterator = new FileLines(__DIR__.'/fixtures/text.txt');

        $expected = array(
            '# Chapter 1',
            '',
            'Some text',
            '',
            '## Section 1',
            '',
            'Some text',
            '',
            '# Chapter 2',
            '',
            'Some text',
            '',
            '## Section 2',
            '',
            'Some text',
            ''
        );

        $this->assertLinesReturnedByIteratorEqual($expected, $iterator);
    }

    private function assertLinesReturnedByIteratorEqual($expected, \Iterator $iterator)
    {
        $this->assertEquals($expected, iterator_to_array($iterator));
    }
}
