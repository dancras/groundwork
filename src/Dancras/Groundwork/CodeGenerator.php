<?php

namespace Dancras\Groundwork;

use Dancras\Groundwork\TemplateCompiler;
use Dancras\Groundwork\TemplateLoader;

class CodeGenerator
{
    const FQCN = '\Dancras\Groundwork\CodeGenerator';

    private $loader;
    private $compiler;
    private $writer;

    public function __construct(
        TemplateLoader $templateLoader,
        TemplateCompiler $templateCompiler,
        $templateWriter
    ) {
        $this->loader = $templateLoader;
        $this->compiler = $templateCompiler;
        $this->writer = $templateWriter;
    }

    public function createFromTemplate($template, $path)
    {
        $template = $this->loader->loadTemplate($template);

        $compiledTemplate = $this->compiler->compile($template);

        $this->writer->writeTemplate($path, $compiledTemplate);
    }
}
