<?php

namespace Dancras\Groundwork;

use Dancras\Groundwork\CodeGenerator;
use Dancras\Groundwork\TemplateCompiler;
use RuntimeException;

class Runner
{
    private $parser;
    private $fileSystem;
    private $executor;

    public function __construct($parser, $fileSystem, $executor)
    {
        $this->parser = $parser;
        $this->fileSystem = $fileSystem;
        $this->executor = $executor;
    }

    public function run($type)
    {
        $runBase = ".groundwork/{$type}";
        $runFile = "{$runBase}/run.php";

        if (!$this->fileSystem->isFile($runFile)) {
            throw new RuntimeException("No groundwork run.php found for {$type}");
        }

        $loader = new TemplateLoader($this->fileSystem, $runBase);
        $compiler = new TemplateCompiler;

        $params = $this->parser->getRunnerParams();
        $params['codeGenerator'] = new CodeGenerator($loader, $compiler, $this->fileSystem);

        $this->parser->prepareCompiler($compiler);

        $this->executor->execute($runFile, $params);
    }

}
