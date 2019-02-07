<?php

class Config{

    public static function get($path = null){
        if($path){
            $items = require_once 'config/'. $path.'.php';
            return $items;
        }
        return false;
    }
}

?>