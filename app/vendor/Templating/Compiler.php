<?php

final class Compiler
{
    public function render(string $template, ?array $data): string
    {
        $templateContent = file_get_contents(__DIR__ . '/../../View/' . $template . '.php');

        return $this->compileTemplate($templateContent, $data);
    }

    private function compileTemplate(string $templateContent, $data): string
    {
        // Handle if blocks
        $templateContent = $this->handleIfBlocks($templateContent, $data);

        // Handle foreach blocks
        $templateContent = $this->handleForeachBlocks($templateContent, $data);

        // Handle placeholders
        return preg_replace_callback('/\[\[(.*?)\]\]/', function ($matches) use ($data) {
            return $this->resolvePlaceholder($matches[1], $data);
        }, $templateContent);
    }

    private function handleIfBlocks(string $templateContent, $data): string
    {
        // Match the if-else blocks
        $pattern = '/\[\[ if (.*?) \]\](.*?)\[\[ else \]\](.*?)\[\[ endif \]\]/s';
        return preg_replace_callback($pattern, function ($matches) use ($data) {
            $conditionStr = trim($matches[1]);
            $ifBlockContent = $matches[2];
            $elseBlockContent = $matches[3];

            // Resolve the condition string to determine its truthiness
            $condition = $this->resolveCondition($conditionStr, $data);

            // Evaluate the condition (assuming it's a boolean)
            if ($condition) {
                return $this->compileTemplate($ifBlockContent, $data);
            } else {
                return $this->compileTemplate($elseBlockContent, $data);
            }
        }, $templateContent);
    }

    private function resolveCondition(string $conditionStr, $data): bool
    {
        // Implement your logic to resolve the condition string
        // For simplicity, we assume direct boolean values or checking existence in data
        $conditionStr = trim($conditionStr);

        if (strpos($conditionStr, '.') !== false) {
            // If condition contains dot notation like session.user
            $parts = explode('.', $conditionStr);
            $value = $data;

            foreach ($parts as $part) {
                if (isset($value[$part])) {
                    $value = $value[$part];
                } else {
                    return false; // If any part is not set, condition is false
                }
            }

            // Check the final value for truthiness
            return (bool)$value;
        } else {
            // If condition is a simple key in $data
            return isset($data[$conditionStr]) && (bool)$data[$conditionStr];
        }
    }

    private function handleForeachBlocks(string $templateContent, $data): string
    {
        // Match the foreach blocks
        $pattern = '/\[\[ for (\w+) in (\w+) \]\](.*?)\[\[ endfor \]\]/s';
        return preg_replace_callback($pattern, function ($matches) use ($data) {
            $itemVar = $matches[1];
            $collectionVar = $matches[2];
            $blockContent = $matches[3];

            if (!isset($data[$collectionVar]) || !is_array($data[$collectionVar])) {
                return '';
            }

            $result = '';
            foreach ($data[$collectionVar] as $item) {
                $result .= $this->compileTemplate($blockContent, array_merge($data, [$itemVar => $item]));
            }

            return $result;
        }, $templateContent);
    }

    private function resolvePlaceholder(string $placeholder, $data): mixed
    {
        $keys = explode('.', $placeholder);
        $value = $data;

        foreach ($keys as $key) {
            if (is_array($value) && isset($value[$key])) {
                $value = $value[$key];
            } elseif (is_object($value)) {
                $getter = 'get' . ucfirst($key);
                if (method_exists($value, $getter)) {
                    $value = $value->$getter();
                } else {
                    return '[[' . $placeholder . ']]';
                }
            } else {
                return '[[' . $placeholder . ']]';
            }
        }

        return $value;
    }
}
