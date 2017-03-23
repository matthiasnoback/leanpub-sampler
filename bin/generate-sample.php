<?php
declare(strict_types = 1);

use Aura\Cli\CliFactory;
use Matthias\LeanpubSampler\SampleTextFileGenerator;

$autoloadFile = array_filter(array(
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../autoload.php'
), 'file_exists');

if ($autoloadFile === null) {
    throw new \RuntimeException('Could not locate the Composer autoload file');
}

require reset($autoloadFile);

$cliFactory = new CliFactory();
$context = $cliFactory->newContext($GLOBALS);
$stdio = $cliFactory->newStdio();

$options = array(
    'dir:',
    'file:',
    'from-subset',
    'all-sections,s'
);

$getopt = $context->getopt($options);

$manuscriptDirectory = (string)$getopt->get('--dir', 'manuscript');
$stdio->outln('Look for manuscript files in: <<yellow>>' . $manuscriptDirectory . '<<reset>>');

$file = (string)$getopt->get('--file', 'manuscript/sample-text.txt');
$stdio->outln('Write sample text to: <<yellow>>' . $file . '<<reset>>');

$addAllSectionMarkers = (bool)$getopt->get('--all-sections');
$stdio->outln('Add all section markers? <<yellow>>' . ($addAllSectionMarkers ? 'yes' : 'no') . '<<reset>>');

$fromSubset = (bool)$getopt->get('--from-subset');
$stdio->outln('Base sample text on Subset.txt? <<yellow>>' . ($fromSubset ? 'yes' : 'no') . '<<reset>>');

$sampleTextFileGenerator = new SampleTextFileGenerator($manuscriptDirectory, $fromSubset, $file, $addAllSectionMarkers);
$sampleTextFileGenerator->generate();

$stdio->outln('<<green>>Done!<<reset>>');
