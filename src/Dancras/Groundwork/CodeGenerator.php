<?php

namespace Dancras\Groundwork;

class CodeGenerator
{
    private $loader;
    private $compiler;
    private $writer;

    public function __construct($templateLoader, $templateCompiler, $templateWriter)
    {
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
