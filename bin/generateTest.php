#!/usr/bin/env php
<?php

$baseDir = realpath(dirname(__FILE__) . '/..');

require_once $baseDir . '/vendor/autoload.php';

require_once $baseDir . '/output/parameter.php';
require_once $baseDir . '/output/parameterTest.php';

$tests = [];
$tests[] = new \OpenApiDataProvider\BooleanParameterExampleTest();

foreach ($tests as $test) {
    $test->testNegativeCases();
    $test->testPositiveCases();
}

