#!/usr/bin/env php
<?php

$baseDir = realpath(dirname(__FILE__) . '/..');

require_once $baseDir . '/vendor/autoload.php';

$options = [
    'schema' => $baseDir . '/examples/petstore.deref.json',
    'output' => $baseDir . '/output/',
];

$generator = new \OpenApiDataProvider\Generator();

$generator->generate($options);