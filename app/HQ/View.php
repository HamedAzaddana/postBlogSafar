<?php

namespace App\HQ;

use Jenssegers\Blade\Blade;

class View
{
    protected $blade;

    public function __construct()
    {
        $viewPath = __DIR__ . '/../Views'; 
        $cachePath = __DIR__ . '/../../cache/views'; 

        $this->blade = new Blade($viewPath, $cachePath);
    }

    public function render($view, $data = [])
    {
        return $this->blade->render($view, $data);
    }
}
