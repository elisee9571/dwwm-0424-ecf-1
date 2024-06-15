<?php

final class Compiler
{
    public function render(string $template, ?array $data = []): void
    { // Ensure that 'toto' is set in the data array$data['toto'] = 'titi';
        extract($data);
        include __DIR__ . '/../../View/' . $template . '.php';
    }
}
