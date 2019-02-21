<?php

class User{
    private $conn;
    private $db;
    private $config;
    private $data;
    private $session_name;
    private $isLoggedIn = false;

    public function __construct(){
        $this->config = Config::get('session');
        $this->session_name = $this->config['session']['session_name'];
        $this->db = DB::getInstance();

        if(Session::exists($this->session_name)){
            $user = Session::get($this->session_name);

            if($this->find($user)){
                $this->isLoggedIn = true;
            }else{
                //logout
            }
        }
    }

    public function create($fields = array()){
        if(!$this->db->insert('users', $fields)){
            throw new Exception("There was a problem creating an account");
        }
    }

    public function find($userId = null){
        if($userId){
            $field = is_numeric($userId) ? 'id' : 'username';
            $data = $this->db->get('*', 'users', [$field, '=', $userId]);

            if ($data->getCount()) {
                $this->data = $data->getFirst();
                return true;
            }
        }
        return false;
    }
    public function logIn($username = null, $password = null){    

        $user = new User();

        $userId = $user->find(Input::get('username'));

        if ($userId) {
            $this->isLoggedIn=true;
            return $user;
        }
        return false;



        /*$stmt = $conn->prepare("SELECT * FROM korisnici");
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach($result as $row) {
            $username = $row['username'];
            $password = $row['password'];
            if(Input::get('username') === $username && Input::get('password') === $password) {
                
                Redirect::to('dashboard');
                return check();
            }  else {
                Redirect::to('login');
            } 
         }
        return false; 
        

        }   */
        
    
    }

    public function data(){
        return $this->data;
    }

    public function check(){
        return $this->isLoggedIn;
    }
}

?>