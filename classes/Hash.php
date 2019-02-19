<?php
class Hash{

    public static function salt($length){
        return uniqid($length);
    }

    public static function make($input, $salt = ''){
        return hash('sha256', $input.$salt);
    }
}


?>