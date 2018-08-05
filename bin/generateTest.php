#!/usr/bin/env php
<?php

$baseDir = realpath(dirname(__FILE__) . '/..');

require_once $baseDir . '/vendor/autoload.php';

$toTest = [
    '\OpenApiDataProvider\BooleanParameterExample' => $baseDir . '/output/parameter/boolean',
    '\OpenApiDataProvider\Int32ParameterExample' => $baseDir . '/output/parameter/int32',
];
$tests = [];

foreach ($toTest as $origClassName => $origFileName) {
    require_once $origFileName . '.php';
    require_once $origFileName . '.test.php';
    $testClassName = $origClassName . 'Test';
    $tests[$origClassName] = new $testClassName();
}

foreach ($tests as $origClassName => $test) {
    echo $origClassName . ': ';
    $test->testNegativeCases();
    $test->testPositiveCases();
    echo 'OK!' . PHP_EOL;
}

