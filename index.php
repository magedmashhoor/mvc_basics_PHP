<?php

require "vendor/autoload.php";

use Core\App;
use App\Controllers\UserController;



//$user = new UserController();
//$user->index();


$basePath = '/mvc_basics'; // Change this to your real folder name, or '' if root

// Get the requested path
$uri = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($uri);
$path = $parsedUrl['path'] ?? '/';

// Remove trailing slash unless it's just "/"
$path = rtrim($path, '/') ?: '/';

// Remove the base path if present
if ($basePath !== '' && str_starts_with($path, $basePath)) {
    $path = substr($path, strlen($basePath)) ?: '/';
}

$url = $path;

$routes = match($url) {
    "/"      => ["HomeController" => "index"],
    "/about" => ["AboutController" => "index"],
    "/user"  => ["UserController" => "index"],
    default  => null, // fallback for 404
};

$app = new App();
$app->dispatch($routes);
