<?php

include_once __DIR__ . '/../Templating/Compiler.php';

abstract class AbstractController
{
    public function render($template, $data = []): void
    {
        $compiler = new Compiler;
        $compiler->render($template, $data);
    }
}