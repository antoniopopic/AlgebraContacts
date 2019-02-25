<?php

require_once 'core/init.php';

Helper::getHeader('Algebra Contacts', 'main-header');

require 'notifications.php'; 

$user = new User();

if($user->check()){
    $user->logout();
}

Redirect::to('index');

?>