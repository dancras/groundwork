<?php

namespace Dancras\Groundwork;

use Dancras\Groundwork\TemplateCompiler;
use Dancras\Groundwork\TemplateLoader;

class CodeGenerator
{
    const FQCN = '\Dancras\Groundwork\CodeGenerator';

    private $loader;
    private $compiler;
    private $fileSystem;

    public function __construct(
        TemplateLoader $templateLoader,
        TemplateCompiler $templateCompiler,
        $fileSystem
    ) {
        $this->loader = $templateLoader;
        $this->compiler = $templateCompiler;
        $this->fileSystem = $fileSystem;
    }

    public function createFromTemplate($template, $path)
    {
        if ($this->fileSystem->isFile($path)) {
            return;
        }

        $template = $this->loader->loadTemplate($template);

        $compiledTemplate = $this->compiler->compile($template);

        $this->fileSystem->writeFile($path, $compiledTemplate);
    }
}
