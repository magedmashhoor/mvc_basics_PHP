<?php

require "vendor/autoload.php";

use App\Controllers\UserController;



$user = new UserController();
$user->index();


[As a Customer], [i want] to create an account,
 [So] i can login into my profile page.
