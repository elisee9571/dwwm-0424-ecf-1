<?php

include_once __DIR__ . '/../Templating/Compiler.php';

abstract class AbstractController
{
    public function render($template, $data = []): string
    {
        $compiler = new Compiler;
        return $compiler->render($template, $data);
    }
}