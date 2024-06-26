<?php

namespace Router;

final readonly class Router
{
    public function getAction(string $routeAction): array
    {
        return explode('::', $routeAction);
    }
}