<?php
class Hash{

    private function __construct(){}
    private function __clone(){}

    public static function salt($length){
        return uniqid($length);
    }

    public static function make($input, $salt = ''){
        return hash('sha256', $input.$salt);
    }

    public static function unique(){
        return self::make(uniqid());
    }
}


?>