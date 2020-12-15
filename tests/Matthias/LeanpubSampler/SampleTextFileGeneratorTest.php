<?php
declare(strict_types = 1);

namespace Matthias\LeanpubSampler\Tests;

use Matthias\LeanpubSampler\SampleTextFileGenerator;
use PHPUnit\Framework\TestCase;

class SampleTextFileGeneratorTest extends TestCase
{
    private $file;
    private $manuscriptDirectory;

    protected function setUp(): void
    {
        $this->file = tempnam(sys_get_temp_dir(), 'SampleTextFileGeneratorTest');
        $this->manuscriptDirectory = __DIR__ . '/fixtures/manuscript';
    }

    protected function tearDown(): void
    {
        unlink($this->file);
    }

    /**
     * @test
     */
    public function it_generates_one_sample_text_file_from_multiple_files_including_all_section_markers()
    {
        $generator = new SampleTextFileGenerator($this->manuscriptDirectory, false, $this->file, true);
        $generator->generate();

        $expected = <<<EOD
-# Part 1

# Chapter 1

# Chapter 2

-# Part 2


# Chapter 3

Sample text

# Chapter 4

More sample text


EOD;

        $this->assertSame($expected, file_get_contents($this->file));
    }

    /**
     * @test
     */
    public function it_generates_one_sample_text_file_from_multiple_files_without_all_section_markers()
    {
        $generator = new SampleTextFileGenerator($this->manuscriptDirectory, false, $this->file, false);
        $generator->generate();

        $expected = <<<EOD

# Chapter 3

Sample text

# Chapter 4

More sample text


EOD;

        $this->assertSame($expected, file_get_contents($this->file));
    }
}
