<?php

    require_once '../models/User.php';
    require_once '../helpers/session_helper.php';

    class connexion {

        private $userModel;
        
        public function __construct(){
            $this->userModel = new User;
        }

        public function register(){
            //Process form
            
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Init data
            $data = [
                
                'user' => trim($_POST['user']),
                'password' => trim($_POST['password']),
                'pwdRepeat' => trim($_POST['pwdRepeat'])
            ];

            //Validate inputs
            if( empty($data['user']) || 
            empty($data['password']) || empty($data['pwdRepeat'])){
                flash("register", "Please fill out all inputs");
                redirect("../signup.php");
            }

            if(!preg_match("/^[a-zA-Z0-9]*$/", $data['user'])){
                flash("register", "Invalid username");
                redirect("../signup.php");
            }

            

            if(strlen($data['password']) < 6){
                flash("register", "Invalid password");
                redirect("../signup.php");
            } else if($data['password'] !== $data['pwdRepeat']){
                flash("register", "Passwords don't match");
                redirect("../signup.php");
            }

            //User with the same name or password already exists
            if($this->userModel->findUserByUsername($data['user'])){
                flash("register", " name already taken");
                redirect("../signup.php");
            }

            //Passed all validation checks.
            //Now going to hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            //Register User
            if($this->userModel->register($data)){
                redirect("../login.php");
            }else{
                die("Something went wrong");
            }
        }

    public function login(){
        //Sanitize POST data
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data=[
            'Uid' => trim($_POST['Uid']),
            'password' => trim($_POST['password'])
        ];

        if(empty($data['Uid']) || empty($data['password'])){
            flash("login", "Please fill out all inputs");
            header("location: ../login.php");
            exit();
        }

        //Check for user
        if($this->userModel->findUserByUsername($data['Uid'], $data['Uid'])){
            //User Found
            $loggedInUser = $this->userModel->login($data['Uid'], $data['password']);
            if($loggedInUser){
                //Create session
                $this->createUserSession($loggedInUser);
            }else{
                flash("login", "Password Incorrect");
                redirect("../login.php");
            }
        }else{
            flash("login", "No user found");
            redirect("../login.php");
        }
    }

    public function createUserSession($user){
        $_SESSION['id'] = $user->id;
       
        $_SESSION['user'] = $user->user;
        redirect("../index.php");
    }

    public function logout(){
        unset($_SESSION['id']);
        unset($_SESSION['user']);
        session_destroy();
        redirect("../login.php");
    }
}

    $init = new connexion;

    //Ensure that user is sending a post request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        switch($_POST['type']){
            case 'register':
                $init->register();
                break;
            case 'login':
                $init->login();
                break;
            default:
            redirect("../index.php");
        }
        
    }else{
        switch($_GET['q']){
            case 'logout':
                $init->logout();
                break;
            default:
            redirect("../index.php");
        }
    }

    