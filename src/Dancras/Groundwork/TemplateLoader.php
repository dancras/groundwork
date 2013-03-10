<?php

namespace Dancras\Groundwork;

class TemplateLoader
{
    const FQCN = '\Dancras\Groundwork\TemplateLoader';

    private $fileSystem;

    private $basePath;

    public function __construct($fileSystem, $basePath)
    {
        $this->fileSystem = $fileSystem;
        $this->basePath = $basePath;
    }

    public function loadTemplate($relativePath)
    {
        return $this->fileSystem->readFile($this->basePath . '/' . $relativePath);
    }
}
