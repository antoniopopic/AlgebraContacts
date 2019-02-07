<?php

class DB{
    private static $instance = null;
    private $config;
    private $conn;
    private $query;
    private $error = false;
    private $results;
    private $count = 0; 

    //Constructor
    private function __construct(){
        $this->config = Config::get('database');

        $driver = $this->config['driver'];
        $db_name = $this->config['driver']['db'];
        $host = $this->config['driver']['host'];
        $user = $this->config['driver']['user'];
        $pass = $this->config['driver']['pass'];
        $dsn = $driver. ':dbname=' . $db_name . 'host=' . $host; 

        try{
            $this->conn = new PDO($dsn, $user, $pass);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    //Singleton pattern
    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new self();
        }        
        return self::$instance; 
    }

    public function query($sql, $params = array()){
        $this->error = false;

        $this->query = $this->conn->prepare($sql);

        if(!empty($params)){
            for (i=1; i<count($params);i++){
                $this->query->bindValue($i, $params[$i-1]);
            }
        }
        else{

        }
    }

    private function action(){

    }

    public function get(){

    }

    public function find(){

    }

    public function delete(){

    }

    public function insert(){

    }

    public function update(){

    }

    public function getConnection(){
        return $this->conn;
    }

    public function getError(){
        return $this->error;
    }

    public function getResults(){
        return $this->results;
    }

    public function getCount(){
        return $this->count;
    }
}

?>