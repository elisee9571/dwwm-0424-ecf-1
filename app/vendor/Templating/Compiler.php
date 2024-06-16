<?php

namespace Templating;

final class Compiler
{
    public function render(string $template, ?array $data = []): string
    {
        ob_start();
        $this->includeTemplate($template, $data);
        return ob_get_clean();
    }

    private function includeTemplate(string $template, array $data): void
    {
        $filePath = __DIR__ . '/../../View/' . $template . '.php';

        if (!file_exists($filePath)) {
            throw new \Exception("Template file not found: $filePath");
        }

        include $filePath;
    }
}
