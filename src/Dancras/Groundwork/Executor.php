<?php

namespace Dancras\Groundwork;

class Executor
{
    const FQCN = '\Dancras\Groundwork\Executor';

    public function execute($file, $params)
    {
        extract($params);

        require $file;
    }
}
