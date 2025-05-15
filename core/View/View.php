<?php

namespace Core\View;

class View{
    public function __construct(){

    }

    public static function render($view,$data = []){
        require 'src/Views/'.$view.'.php';
    }
}