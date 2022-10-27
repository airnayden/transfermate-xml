<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class BaseController
{
    /**
     * @var Environment
     */
    protected Environment $output;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../resource/template');
        $this->output = new Environment($loader, [
            //'cache' => __DIR__ . '/../../storage/cache/twig',
            'cache' => false
        ]);
    }
}