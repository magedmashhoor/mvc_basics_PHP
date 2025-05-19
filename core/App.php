<?php

namespace Core;

use ReflectionClass;
use ReflectionMethod;

class App
{
    public function dispatch($route)
    {
        if (!$route || !is_array($route)) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        $controllerName = key($route);
        $method = $route[$controllerName];

        $controllerClass = "App\\Controllers\\{$controllerName}";

        if (!class_exists($controllerClass)) {
            die("Controller '$controllerClass' not found.");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            die("Method '$method' not found in $controllerClass.");
        }

        // Use reflection to resolve method dependencies
        $reflection = new ReflectionMethod($controller, $method);
        $parameters = $reflection->getParameters();
        $dependencies = [];

        foreach ($parameters as $param) {
            $type = $param->getType();

            if ($type && !$type->isBuiltin()) {
                $className = $type->getName();

                // Simple service container: instantiate the class
                if (class_exists($className)) {
                    $dependencies[] = new $className();
                } else {
                    die("Dependency class '$className' not found.");
                }
            } else {
                // You could support default values here if needed
                $dependencies[] = null;
            }
        }

        echo $reflection->invokeArgs($controller, $dependencies);
    }
}
