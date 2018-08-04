<?php

namespace OpenApiDataProvider;

class Generator
{

    private $result = '';

    public function generate(): void
    {
        $m = new \Mustache_Engine([
            'loader' => new \Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/../templates'),
        ]);
        $this->result = $m->render('index', array('planet' => 'World'));
        echo $this->result;
    }

}