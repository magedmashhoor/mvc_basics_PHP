<?php

namespace App\Models;

use Core\Model;

class Users extends Model{

    //protected string $table = 'users';

    public function __construct(){}

    public function getUsers(){
        return [
            ['Name'=>'Nagd Ali Abdu','Age'=>38,'Details'=>'Solutions Archtect'],
            ['Name'=>'Salem','Age'=>45,'Details'=>'Full stack'],
            ['Name'=>'Omer','Age'=>30,'Details'=>'Flutter dev']
        ];
    }
}