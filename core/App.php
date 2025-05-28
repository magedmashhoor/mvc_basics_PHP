<?php

namespace Core;

use ReflectionClass;
use ReflectionMethod;

/**
 * Core application router and dispatcher
 * Handles:
 * - Route resolution
 * - Controller instantiation
 * - Method invocation
 * - Dependency injection
 */
class App
{
    /**
     * Main dispatch method that routes requests to controllers
     * @param array $route Associative array ['ControllerName' => 'methodName']
     */
    public function dispatch($route)
    {
        // Validate route configuration exists and is properly formatted
        if (!$route || !is_array($route)) {
            http_response_code(404);
            echo "404 Not Found , please check";
            return;
        }

        // Extract controller name (array key) and method name (array value)
        // Example: From ['UserController' => 'index'] gets:
        // - $controllerName = 'UserController'
        // - $method = 'index'
        $controllerName = key($route);
        $method = $route[$controllerName];

        // Build fully qualified controller class name with namespace
        // Example: Converts 'UserController' to 'App\Controllers\UserController'
        $controllerClass = "App\\Controllers\\{$controllerName}";

        // Verify controller class exists
        if (!class_exists($controllerClass)) {
            die("Controller '$controllerClass' not found.");
        }

        // Instantiate the controller
        $controller = new $controllerClass();

        // Verify the method exists in the controller
        if (!method_exists($controller, $method)) {
            die("Method '$method' not found in $controllerClass.");
        }

        // Use Reflection to inspect the controller method
        $reflection = new ReflectionMethod($controller, $method);
        
        // Get all parameters required by the method
        $parameters = $reflection->getParameters();
        
        // Prepare array for dependency injection
        $dependencies = [];

        // Process each method parameter
        foreach ($parameters as $param) {
            // Get parameter type hint
            $type = $param->getType();

            // Check if parameter is type-hinted (not primitive type)
            if ($type && !$type->isBuiltin()) {
                $className = $type->getName();

                // Simple dependency injection: instantiate required classes
                if (class_exists($className)) {
                    $dependencies[] = new $className();
                } else {
                    die("Dependency class '$className' not found.");
                }
            } else {
                // For non-type-hinted parameters, pass null
                // (Could be enhanced to support default values)
                $dependencies[] = null;
            }
        }

        // Execute the controller method with resolved dependencies
        // and output the result
        echo $reflection->invokeArgs($controller, $dependencies);
    }
}