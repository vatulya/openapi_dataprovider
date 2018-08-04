#!/usr/bin/env php
<?php

$baseDir = realpath(dirname(__FILE__) . '/..');

require_once $baseDir . '/vendor/autoload.php';

$options = [
    'schema' => $baseDir . '/examples/petstore.json',
    'output' => $baseDir . '/output/',
];

$schema = file_get_contents($options['schema']);
$schema = json_decode($schema, true);

$generator = new \OpenApiDataProvider\Generator();

$generator->generate([
    'schema' => $schema,
    'output' => $options['output'],
]);