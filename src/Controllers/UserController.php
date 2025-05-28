<?php
/**
 * USER CONTROLLER CLASS
 * Responsibilities:
 * 1. Handles user-related HTTP requests
 * 2. Interacts with User model
 * 3. Renders appropriate views
 */
namespace App\Controllers;

// Import required classes
use App\Models\Users;      // User data model
use Core\View\View;       // View rendering engine
use Core\Requests;        // HTTP request handler

class UserController
{
    /**
     * CONSTRUCTOR
     * - Ideal place for initialization logic
     * - Currently empty but can be used for:
     *   - Authentication checks
     *   - Dependency injections
     *   - Setup tasks
     */
    public function __construct()
    {
        // Potential initialization code would go here
        // Example: $this->checkAuth();
    }

    /**
     * INDEX ACTION
     * - Default controller method
     * - Typically shows a dashboard or listing
     * 
     * @param Requests $request - HTTP request object
     */
    public function index(Requests $request)
    {
        /**
         * DEBUGGING OUTPUT
         * - print_r shows raw request data
         * - In production, use logging instead
         * - Example flow:
         *   1. Get request data
         *   2. Process data
         *   3. Return response
         */
        print_r($request->all());
        
        // Typically you would:
        // 1. Get data from model
        // $users = (new Users())->getAll();
        // 2. Render view
        // View::render('users/index', ['users' => $users]);
    }

    /**
     * LIST ACTION
     * - Retrieves and displays user list
     * - Example workflow:
     *   1. Get data from Model
     *   2. Prepare data for View
     *   3. Render View with data
     */
    public function list()
    {
        // 1. Instantiate User model
        $user = new Users();
        
        // 2. Get user data from model
        $userData = $user->GetDoctorInfo();
        
        /**
         * RENDER VIEW
         * Parameters:
         * 1. View template name (matches src/Views/home.php)
         * 2. Data array to expose to view
         * 
         * View will receive $users variable containing:
         * [
         *    ['Name' => 'Nagd Ali Abdu', ...],
         *    ['Name' => 'Salem', ...],
         *    ...
         * ]
         */
        View::render("home", ['users' => $userData]);
    }
}