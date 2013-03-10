<?php

namespace Dancras\Groundwork;

use Dancras\Groundwork\Executor;
use Dancras\Groundwork\PHPInputParser;
use Dancras\Groundwork\Runner;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends Command
{
    private $fileSystem;

    public function __construct($fileSystem)
    {
        $this->fileSystem = $fileSystem;

        parent::__construct('create');
    }

    protected function configure()
    {
        $this->setDescription('Generates files from groundwork templates');

        $this->addArgument(
            'template',
            InputArgument::REQUIRED,
            'The name of your groundwork template in .groundwork'
        );

        $this->addArgument(
            'name',
            InputArgument::REQUIRED,
            'The name used by your template when creating files'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parser = new PHPInputParser($input);
        $runner = new Runner(
            $parser,
            $this->fileSystem,
            new Executor
        );

        $runner->run($input->getArgument('template'));

        $output->writeln("Command run successfully");
    }
}
