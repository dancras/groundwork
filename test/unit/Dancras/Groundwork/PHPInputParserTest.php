<?php

namespace test\unit\Dancras\Groundwork;

use Dancras\Groundwork\PHPInputParser;
use Dancras\Groundwork\TemplateCompiler;
use Doubles\Doubles;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Input\InputInterface;

class PHPInputParserTest extends PHPUnit_Framework_TestCase
{
    private $parser;
    private $input;
    private $compiler;

    public function setUp()
    {
        $this->input = Doubles::fromInterface('\Symfony\Component\Console\Input\InputInterface');
        $this->compiler = Doubles::fromClass(TemplateCompiler::FQCN);

        $this->parser = new PHPInputParser($this->input);
    }

    public function testPrepareCompilerGetsNameArgumentFromInput()
    {
        $this->parser->prepareCompiler($this->compiler);

        $this->assertSame('name', $this->input->spy('getArgument')->oneCallArg(0));
    }

    public function testPrepareCompilerSetsClassNameValue()
    {
        $this->input->stub('getArgument', 'MyVendor\MyProject\MyClass');

        $this->parser->prepareCompiler($this->compiler);

        $this->compiler->spy('setValue')->checkArgs('className', 'MyClass');
    }

    public function testPrepareCompilerSetsNamespaceValue()
    {
        $this->input->stub('getArgument', 'MyVendor\MyProject\MyClass');

        $this->parser->prepareCompiler($this->compiler);

        $this->compiler->spy('setValue')->checkArgs('namespace', 'MyVendor\MyProject');
    }

    public function testGetRunnerParamsHasCorrectPSRPath()
    {
        $this->input->stub('getArgument', 'MyVendor\MyProject\MyClass');

        $params = $this->parser->getRunnerParams();

        $this->assertSame('MyVendor/MyProject/MyClass.php', $params['psrPath']);
    }

}
