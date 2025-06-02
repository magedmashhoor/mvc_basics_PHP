<?php
// 1. BOOTSTRAPPING - Load the Composer autoloader to make classes available
require "vendor/autoload.php";

// 2. IMPORT - Bring in the Core App class that handles routing
use Core\App;

// 3. PATH CONFIGURATION - Set base path if your project isn't in web root
// Example: If your project is at http://localhost/mvc_basics/
$basePath = '/mvc_basics'; 
// Change to empty string if in root: $basePath = '';

// 4. URI PARSING - Extract the clean path from the request URL
// parse_url() removes query strings (?foo=bar) and fragments (#section)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 5. PATH NORMALIZATION - Remove base path and trailing slashes
// a) str_replace() removes the base path prefix
// b) rtrim() removes trailing slash
// c) ?: '/' converts empty path to root
$path = rtrim(str_replace($basePath, '', $uri), '/') ?: '/';

// 6. ROUTE DEFINITION - Match the path to controller/action pairs
$routes = match($path) {
    // Root path -> HomeController's index method
    "/"                => ["HomeController" => "index"],
    
    // /about -> AboutController's index method  
    "/about"          => ["AboutController" => "index"],
    
    // /user -> UserController's index method
    "/user"           => ["UserController" => "index"],
    
    // /user/list -> UserController's list method
    "/user/list"      => ["UserController" => "list"],
    
    // Doctor routes
    "/doctors/add"    => ["DoctorController" => "add"],
    "/doctors/store"  => ["DoctorController" => "store"],
    
    // No match -> null triggers 404
    default           => null, 
};

// 7. APPLICATION INITIALIZATION - Create the App instance
$app = new App();

// 8. REQUEST DISPATCHING - Route the request to the controller
$app->dispatch($routes);
?>