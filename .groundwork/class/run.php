<?php

/** @var $codeGenerator \Dancras\Groundwork\CodeGenerator */
/** @var $psrPath string */

$codeGenerator->createFromTemplate('class', "src/{$psrPath}.php");
$codeGenerator->createFromTemplate('testcase', "test/unit/{$psrPath}Test.php");
