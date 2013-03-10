<?php

namespace test\unit\Dancras\Groundwork;

use Dancras\Groundwork\CodeGenerator;
use Dancras\Groundwork\TemplateCompiler;
use Dancras\Groundwork\TemplateLoader;
use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class CodeGeneratorTest extends PHPUnit_Framework_TestCase
{
    private $codeGenerator;

    private $templateLoader;
    private $templateCompiler;
    private $fileSystem;

    public function setUp()
    {
        $this->templateLoader = Doubles::fromClass(TemplateLoader::FQCN);
        $this->templateCompiler = Doubles::fromClass(TemplateCompiler::FQCN);
        $this->fileSystem = Doubles::fromClass('\Dancras\Groundwork\FileSystem');

        $this->codeGenerator = new CodeGenerator(
            $this->templateLoader,
            $this->templateCompiler,
            $this->fileSystem
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

        $this->fileSystem->spy('writeFile')->checkArgs('path/to/output', 'compiled contents');
    }

}
