<?php

namespace Core;
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

        //echo $controllerName. ' '.$method;
        
        $controllerClass =  "App\\Controllers\\{$controllerName}" ;
        
        if (!class_exists($controllerClass)) {
            die("Controller '$controllerName' not found.");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            die("Method '$method' not found in $controllerName.");
        }

        echo $controller->$method();
    }
}
