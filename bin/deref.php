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

$destination = $options['destination'];
if (!file_exists(dirname($destination))) {
    mkdir(dirname($destination), 0777, true);
}
file_put_contents($destination, json_encode($result));
