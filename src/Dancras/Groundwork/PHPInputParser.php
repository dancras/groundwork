<?php

namespace Dancras\Groundwork;

use Dancras\Groundwork\TemplateCompiler;
use Symfony\Component\Console\Input\InputInterface;

class PHPInputParser
{
    const FQCN = '\Dancras\Groundwork\PHPInputParser';

    private $input;

    public function __construct(InputInterface $input)
    {
        $this->input = $input;
    }

    public function prepareCompiler(TemplateCompiler $compiler)
    {
        $segments = explode('\\', $this->input->getArgument('name'));

        $compiler->setValue('className', end($segments));

        $compiler->setValue('namespace', join('\\', array_slice($segments, 0, -1)));
    }

    public function getRunnerParams()
    {
        return array(
            'psrPath' => str_replace('\\', '/', $this->input->getArgument('name'))
        );
    }

}
