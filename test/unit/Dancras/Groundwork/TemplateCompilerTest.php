<?php

namespace test\unit\Dancras\Groundwork;

use Dancras\Groundwork\TemplateCompiler;
use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class TemplateCompilerTest extends PHPUnit_Framework_TestCase
{
    private $templateCompiler;

    public function setUp()
    {
        $this->templateCompiler = new TemplateCompiler;
    }

    public function testCompileReplacesPlaceholdersWithSetValues()
    {
        $this->templateCompiler->setValue('placeholder', 'foobar');

        $output = $this->templateCompiler->compile('template %placeholder%');

        $this->assertSame('template foobar', $output);
    }

}
