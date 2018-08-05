#!/usr/bin/env php
<?php

$baseDir = realpath(dirname(__FILE__) . '/..');

require_once $baseDir . '/vendor/autoload.php';

$options = [
    'schema' => $baseDir . '/examples/petstore.json',
    'destination' => $baseDir . '/output/petstore.deref.json',
];

$deref = new \OpenApiDataProvider\DeRef();

$result = $deref->deref($options);

