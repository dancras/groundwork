<?php

namespace test\unit\Dancras\Groundwork;

use Dancras\Groundwork\CodeGenerator;
use Dancras\Groundwork\PHPInputParser;
use Dancras\Groundwork\Runner;
use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class RunnerTest extends PHPUnit_Framework_TestCase
{
    private $runner;
    private $fileSystem;
    private $parser;
    private $executor;

    public function setUp()
    {
        $this->parser = Doubles::fromClass(PHPInputParser::FQCN);
        $this->fileSystem = Doubles::fromClass('\Dancras\Groundwork\FileSystem');
        $this->fileSystem->stub('isFile', true);
        $this->executor = Doubles::fromClass('\Dancras\Groundwork\Executor');

        $this->runner = new Runner($this->parser, $this->fileSystem, $this->executor);
    }

    public function testRunThrowsExceptionGivenNoRunFileForType()
    {
        $this->fileSystem->stub('isFile', false);

        $this->setExpectedException('RuntimeException');
        $this->runner->run('my-type');
    }

    public function testRunChecksRunFilePath()
    {
        $this->runner->run('my-type');

        $this->fileSystem->spy('isFile')->checkArgs('.groundwork/my-type/run.php');
    }

    public function testRunPreparesCompilerWithParser()
    {
        $this->runner->run('my-type');

        $this->assertSame(1, $this->parser->spy('prepareCompiler')->callCount());
    }

    public function testRunExecutesRunFile()
    {
        $this->runner->run('my-type');

        $this->assertSame('.groundwork/my-type/run.php', $this->executor->spy('execute')->oneCallArg(0));
    }

    public function testRunExecutesRunFileWithParserParams()
    {
        $this->parser->stub('getRunnerParams', array(
            'foo' => 'bar'
        ));

        $this->runner->run('my-type');

        $this->assertSame('bar', $this->executor->spy('execute')->arg(0, 1)['foo']);
    }

    public function testRunExecutesRunFileWithCodeGeneratorAsParam()
    {
        $this->runner->run('my-type');

        $this->assertInstanceOf(CodeGenerator::FQCN, $this->executor->spy('execute')->arg(0, 1)['codeGenerator']);
    }

}
