<?php

namespace Dancras\Groundwork;

use Dancras\Groundwork\FileSystem;
use Dancras\Groundwork\RunCommand;
use RuntimeException;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application extends ConsoleApplication
{
    const FQCN = '\Dancras\Groundwork\Application';

    public function __construct($projectPath)
    {
        if (!is_dir($projectPath . '/.groundwork')) {
            throw new RuntimeException(
                'No .groundwork folder found.' . PHP_EOL
            );
        }

        parent::__construct('groundwork', '1.0.0');


        $fileSystem = new FileSystem($projectPath);

        $this->add(new CreateCommand($fileSystem));
    }
}
