<?php

namespace Router;

class Router
{
    public function getAction(string $routeAction): array
    {
        return explode('::', $routeAction);
    }
}