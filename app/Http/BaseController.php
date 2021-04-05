<?php

namespace App\Http;

class BaseController
{
    protected $templateEngine;
    
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../views/');

        $this->templateEngine = new \Twig\Environment($loader, [
            'cache' => 'false',
            'debug' => 'true',
        ]);
    }

    public function renderHTML($fileName, $data = [])
    {
        return $this->templateEngine->render($fileName, $data);
    }
}
