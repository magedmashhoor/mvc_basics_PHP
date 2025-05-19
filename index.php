<?php

require "vendor/autoload.php";

use Core\App;

// Define your base path (if your project is not in the web root)
$basePath = '/mvc_basics'; // Set to '' if in root

// Parse the requested URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Normalize path: remove base path and trailing slash
$path = rtrim(str_replace($basePath, '', $uri), '/') ?: '/';

$routes = match($path) {
    "/"           => ["HomeController" => "index"],
    "/about"      => ["AboutController" => "index"],
    "/user"       => ["UserController" => "index"],
    "/user/list"  => ["UserController" => "list"],
    default       => null, // fallback to 404
};

$app = new App();
$app->dispatch($routes);
