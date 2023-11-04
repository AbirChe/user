<?php
require_once '../libraries/Database.php';

class User {
   
    private $db;

    public function __construct(){
      
        $this->db = new Database;
    }

    //Find user by email or username
    public function findUserByUsername($Uid){
        $this->db->query('SELECT * FROM connexion WHERE user = :Uid ');
        
        $this->db->bind(':Uid', $Uid);

        $row = $this->db->single();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    //Register User
    public function register($data){
        $this->db->query('INSERT INTO connexion ( user, password) 
        VALUES ( :Uid, :password)');

        //Bind values
        $this->db->bind(':Uid', $data['user']);
        $this->db->bind(':password', $data['password']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Login user
    public function login($nameOrEmail, $password){
    $row = $this->findUserByUsername($nameOrEmail);

        if($row == false) return false;

        $hashedPassword = $row->password;
        if(password_verify($password, $hashedPassword)){
            return $row;
        }else{
            return false;
        }
    }

    
    
}