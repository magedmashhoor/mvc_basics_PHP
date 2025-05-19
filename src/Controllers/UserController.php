<?php

namespace App\Controllers;

use App\Models\Users;
use Core\View\View;
use Core\Requests;

class UserController{

    public function __construct(){
       
    }

    public function index(Requests $request){
        
        print_r($request->all());

    }

    public function list(){
      $user = new Users();
        $userData = $user->getUsers();
        View::render("home",['users' => $userData]);  
    }
}