<?php

namespace Dancras\Groundwork;

class FileSystem
{
    const FQCN = '\Dancras\Groundwork\FileSystem';

    private $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function isFile($path)
    {
        return file_exists($this->getAbsolutePath($path));
    }

    public function getAbsolutePath($relativePath)
    {
        return "{$this->basePath}/$relativePath";
    }

    public function readFile($path)
    {
        return file_get_contents($this->getAbsolutePath($path));
    }

    public function writeFile($path, $contents)
    {
        $absolutePath = $this->getAbsolutePath($path);
        $directoryPath = dirname($absolutePath);

        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        return file_put_contents($absolutePath, $contents);
    }
}
