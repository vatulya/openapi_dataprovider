<?php

namespace OpenApiDataProvider;

class Generator
{

    private $result = '';

    public function generate(array $options): void
    {
        $schema = $options['schema'];
        $output = $options['output'];

        $m = new \Mustache_Engine([
            'loader' => new \Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/../templates'),
        ]);
        $this->result = $m->render('index', ['schema' => $schema]);

        $destination = $output . 'index.php';

        if (!file_exists(dirname($destination))) {
            mkdir(dirname($destination), 0777, true);
        }
        file_put_contents($destination, $this->result);

        echo $destination;
        echo $this->result;
    }

}