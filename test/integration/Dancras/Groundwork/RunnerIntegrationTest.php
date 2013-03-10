<?php

namespace test\integration\Dancras\Groundwork;

use Dancras\Groundwork\Executor;
use Dancras\Groundwork\FileSystem;
use Dancras\Groundwork\PHPInputParser;
use Dancras\Groundwork\Runner;
use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class RunnerIntegrationTest extends PHPUnit_Framework_TestCase
{
    private $tempPath;
    private $tempFixturePath;
    private $fileSystem;
    private $executor;

    public function setUp()
    {
        $fixturePath = __DIR__ . '/../../../resources/fixture';
        $this->tempPath = sys_get_temp_dir() . '/groundwork';
        $this->tempFixturePath = $this->tempPath . '/fixture';

        if (is_dir($this->tempPath)) {
            shell_exec("rm -r {$this->tempPath}");
        }

        mkdir($this->tempPath);
        shell_exec("cp -r {$fixturePath} {$this->tempPath}");

        $this->fileSystem = new FileSystem($this->tempFixturePath);
        $this->executor = new Executor();
    }

    public function tearDown()
    {
        shell_exec("rm -r {$this->tempPath}");
    }

    public function testRunnerWithDummyParser()
    {
        $parser = Doubles::fromClass(PHPInputParser::FQCN);

        $parser->stub('getRunnerParams', array(
            'dummyPath' => 'src/DummyFile.php'
        ));

        $parser->mock('prepareCompiler', function ($methodName, $arguments) {
            $arguments[0]->setValue('dummyValue', 'foobar');
        });

        $runner = new Runner($parser, $this->fileSystem, $this->executor);

        $runner->run('dummy');

        $contents = file_get_contents($this->tempFixturePath . '/src/DummyFile.php');
        $this->assertSame('foobar', trim($contents));
    }

}
