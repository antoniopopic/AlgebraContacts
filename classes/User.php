<?php

class User{
    private $conn;
    private $db;
    private $config;
    private $data;
    private $session_name;
    private $cookieName;
    private $cookieDuration;
    private $isLoggedIn = false;

    public function __construct($userID=null){
        $config = Config::get('session');
        $this->session_name = $config['session']['session_name'];
        $this->cookieName = $config['remember']['cookie_name'];
        $this->cookieDuration = $config['remember']['cookie_expiery'];
        $this->db = DB::getInstance();

        if (!$userID) {
            if(Session::exists($this->session_name)){
                $user = Session::get($this->session_name);
    
                if($this->find($user)){
                    $this->isLoggedIn = true;
                }
            }    
        } else {
            $this->find($userID);
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
    public function login($username = null, $password = null, $remember = null){    
        
        if (!$username && !$password && $this->exists()) {
            Session::put($this->session_name, $this-data()->id);
            return true;
        } else {
            $user = $this->find($username);
            //echo '<pre>'; var_dump($this->data()->password); die();
            if($user){
                        //pwd iz baze === haširani pwd
                if($this->data()->password === Hash::make($password, $this->data()->salt)){

                    Session::put($this->session_name, $this->data()->id);
                    if($remember){
                        $hash = Hash::unique();
                        //checking if exists in db, table sessions for user
                        $hashCheck = $this->db->get('hash', 'sessions', ['user_id', '=', $this->data()->id]);
                        //if not exists, insert into sessions table
                        if(!$hashCheck->getCount()){
                            $this->db->insert('sessions',[
                                'hash'      => $hash,
                                'user_id'   => $this->data()->id
                            ]);
                        }else{
                            $hash = $hashCheck->getFirst()->hash;
                        }
                        Cookie::put($this->cookieName, $hash, $this->cookieDuration);
                    }
                    return true;
                }
            }
        }
        


        
        return false;        
    }

    public function logout(){
        $this->db->delete('sessions', ['user_id', '=', $this->data()->id]);
        Session::delete($this->session_name);
        Cookie::delete($this->cookieName);
        session_destroy();
    }

    public function exists(){
        return (!empty($this->data)) ? true : false ;
    }

    public function data(){
        return $this->data;
    }

    public function check(){
        return $this->isLoggedIn;
    }
}

?>