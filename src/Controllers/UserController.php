<?php

namespace App\Controllers;

use App\Models\Users;
use Core\View\View;

class UserController{

    public function __construct(){
       
    }

    public function index(){
        $user = new Users();
        
        $userData = $user->getUsers();
        View::render("home",['users' => $userData]);
    }
}