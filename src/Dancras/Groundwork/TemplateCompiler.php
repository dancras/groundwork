<?php

namespace Dancras\Groundwork;

class TemplateCompiler
{
    const FQCN = '\Dancras\Groundwork\TemplateCompiler';

    private $values = array();

    public function setValue($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function compile($template)
    {
        $compiled = $template;

        foreach ($this->values as $key => $value) {
            $compiled = str_replace("%{$key}%", $value, $compiled);
        }

        return $compiled;
    }
}
