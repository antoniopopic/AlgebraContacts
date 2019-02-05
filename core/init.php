<?php
session_start();
session_regenerate_id();

spl_autoload_register(function($class){
    require_once 'classes/'.$class.'.php';
});

require_once 'functions/sanitize.php';

?>