<?php

include_once __DIR__ . '/../Templating/Compiler.php';

abstract class AbstractController
{
    public function render($template, $data = [])
    {
        $compiler = new Compiler;
        return $compiler->render($template, $data);
    }
}
