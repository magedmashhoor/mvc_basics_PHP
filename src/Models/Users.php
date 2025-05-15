<?php

namespace App\Models;

class Users{

    public function __construct(){}

    public function getUsers(){
        return [
            ['Name'=>'Nagd Ali Abdu','Age'=>38,'Details'=>'Solutions Archtect'],
            ['Name'=>'Salem','Age'=>45,'Details'=>'Full stack'],
            ['Name'=>'Omer','Age'=>30,'Details'=>'Flutter dev']
        ];
    }
}