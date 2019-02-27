<?php

session_start();
//session_regenerate_id();

spl_autoload_register(function($class){
    require_once 'classes/'.$class.'.php';
});

error_reporting(Config::get('app')['error_reporting']);
$displayErrors = Config::get('app')['display_errors'];
ini_set('display_errors', $displayErrors);
ini_set('display_startup_errors', $displayErrors);

require_once 'functions/sanitize.php';

$sessionConfig = Config::get('session');
$session_name = $sessionConfig['session']['session_name'];
$cookie_name = $sessionConfig['remember']['cookie_name'];

if (!Session::exists($session_name) && Cookie::exists($cookie_name)) {
    
    $cookieHash = Cookie::get($cookie_name);
    $dbHash = DB::getInstance()->get('*', 'sessions', ['hash', '=', $cookieHash]);
   
    if($dbHash->getCount()){
        $userID = $dbHash->getFirst()->user_id;
        $user = new User($userID);
        $user->login();
    }

    /* $user = new User($id);
    $user->login(); */
}

?>