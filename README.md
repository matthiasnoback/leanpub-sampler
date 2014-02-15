# Leanpub Sampler

[![Build Status](https://travis-ci.org/matthiasnoback/leanpub-sampler.png?branch=master)](https://travis-ci.org/matthiasnoback/leanpub-sampler)

This tool can be used to generate sample text for Leanpub books.

## Installation

Install with [Composer](https://getcomposer.org/). Add a ``composer.json`` file to the root of your Leanpub book
project (one directory higher than ``manuscript/``):

    {
        "require": {
            "matthiasnoback/leanpub-sampler": "~0.1"
        }
    }

Then run ``composer update``. A ``vendor/`` directory will be created, containing the Leanpub sampler and its
dependencies.

## Usage

First you need to edit your manuscript files and add markers for the sample texts:

    # A regular chapter

    ## A regular section

    Some text.

    %% begin sample

    ## A sample section

    Some sample text.

    %% end sample

Then run:

    php vendor/bin/generate-sample.php

The sampler will generate sample text based on the ``%% begin sample`` and ``%% end sample`` markers. It scans all
``.txt`` or ``.md`` files inside the ``manuscript/`` directory, including its subdirectories.

The result is a new file, ``manuscript/sample-text.txt``, that contains all the sample text.

### Add all section titles (parts, chapters, sections)

Using the command-line option ``--all-sections`` or ``-s`` you can instruct the sampler to automatically add any part,
chapter or section title to the sample text:

    php vendor/bin/generate-sample.php -s

This is useful if you want to preserve the original structure of your manuscript in the generated sample file. It is
also useful because if all the part, chapter and section titles are present in the sample file, Leanpub will add the
full table of contents to the generated preview file.

### Last step: mention ``sample-text.txt`` in ``Sample.txt``

When Leanpub generates a preview file, it looks at the ``manuscript/Sample.txt`` file. All files mentioned there will
be added to the generated preview file. Make sure you add the ``sample-text.txt`` file to the list too:

The contents of ``manuscript/Sample.txt`` should be:

    sample-text.txt

#### Suggestions

The Leanpub sampler scans the manuscript files in alphabetical order. So to preserve initial order, it's best to sort
your manuscript files alphabetically too, like:

    00-chapter1.txt
    01-chapter2.txt
    ...
