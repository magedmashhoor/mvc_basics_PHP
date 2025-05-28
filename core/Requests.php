<?php
//Request Class
namespace Core;

class Requests{

    public function __construct(){}

    public function all(){
        return $_REQUEST;
    }
}