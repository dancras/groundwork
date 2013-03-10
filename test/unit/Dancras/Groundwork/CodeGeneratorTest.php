<?php

namespace test\unit\Dancras\Groundwork;

use Dancras\Groundwork\CodeGenerator;
use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class CodeGeneratorTest extends PHPUnit_Framework_TestCase
{
    private $codeGenerator;

    private $templateLoader;
    private $templateCompiler;
    private $templateWriter;

    public function setUp()
    {
        $this->templateLoader = Doubles::fromClass('\Dancras\Groundwork\TemplateLoader');
        $this->templateCompiler = Doubles::fromClass('\Dancras\Groundwork\TemplateCompiler');
        $this->templateWriter = Doubles::fromClass('\Dancras\Groundwork\TemplateWriter');

        $this->codeGenerator = new CodeGenerator(
            $this->templateLoader,
            $this->templateCompiler,
            $this->templateWriter
        );
    }

    public function testCreateFromTemplateCompilesContentsOfTemplate()
    {
        $this->templateLoader->stub('loadTemplate', 'contents');

        $this->codeGenerator->createFromTemplate('template', 'path/to/output');

        $this->templateLoader->spy('loadTemplate')->checkArgs('template');
        $this->templateCompiler->spy('compile')->checkArgs('contents');
    }

    public function testCreateFromTemplateWritesCompiledTemplate()
    {
        $this->templateCompiler->stub('compile', 'compiled contents');

        $this->codeGenerator->createFromTemplate('template', 'path/to/output');

        $this->templateWriter->spy('writeTemplate')->checkArgs('path/to/output', 'compiled contents');
    }

}
