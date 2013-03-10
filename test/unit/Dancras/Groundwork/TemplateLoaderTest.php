<?php

namespace test\unit\Dancras\Groundwork;

use Dancras\Groundwork\FileSystem;
use Dancras\Groundwork\TemplateLoader;
use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class TemplateLoaderTest extends PHPUnit_Framework_TestCase
{
    private $templateLoader;

    private $fileSystem;

    public function setUp()
    {
        $this->fileSystem = Doubles::fromClass('\Dancras\Groundwork\FileSystem');

        $this->templateLoader = new TemplateLoader($this->fileSystem, 'base/path');
    }

    public function testLoadTemplateReadsTemplateRelativeToBasePath()
    {
        $this->templateLoader->loadTemplate('template/path');

        $this->fileSystem->spy('readFile')->checkArgs('base/path/template/path');
    }

    public function testLoadTemplateReturnsContentsOfFile()
    {
        $this->fileSystem->stub('readFile', 'contents');

        $output = $this->templateLoader->loadTemplate('template/path');

        $this->assertSame('contents', $output);
    }

}
