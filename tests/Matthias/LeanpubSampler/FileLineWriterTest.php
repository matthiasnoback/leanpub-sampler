<?php
declare(strict_types = 1);

namespace Matthias\LeanpubSampler\Tests;

use Matthias\LeanpubSampler\FileLineWriter;
use PHPUnit\Framework\TestCase;

class FileLineWriterTest extends TestCase
{
    private $filename;

    /**
     * @var FileLineWriter
     */
    private $writer;

    protected function setUp()
    {
        $this->filename = tempnam(sys_get_temp_dir(), 'FileLineWriterTest');
        $this->writer = new FileLineWriter($this->filename);
    }

    protected function tearDown()
    {
        unlink($this->filename);
    }

    /**
     * @test
     */
    public function it_writes_all_values_from_an_iterator_to_a_file_as_lines()
    {
        $lines = new \ArrayIterator(array(
            'Line 1',
            'Line 2',
            ''
        ));

        $this->writer->writeLines($lines);

        $this->assertSameFileContents("Line 1\nLine 2\n\n");
    }

    private function assertSameFileContents($expected)
    {
        $this->assertSame($expected, file_get_contents($this->filename));
    }
}
