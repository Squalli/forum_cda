<?php
    namespace Controller;

    use App\Session;
    use Model\Managers\UserManager;
    
    class SecurityController{

        public function index(){

            return $this->login();
        }
        
        public function login(){
            if(!empty($_POST)){

                $username = filter_input(INPUT_POST, "username", FILTER_VALIDATE_REGEXP,
                    array(
                        "options" => array("regexp"=>'/[A-Za-z0-9]{4,}/')
                    )
                );
                $pass = filter_input(INPUT_POST, "pass", FILTER_VALIDATE_REGEXP,
                    array(
                        "options" => array("regexp"=>'/[A-Za-z0-9]{6,32}/')
                    )
                );

                if($username && $pass){
                    $manager = new UserManager();
                    $dbPass = array_values($manager->retrievePassword($username));
                    if(password_verify($pass, $dbPass[0])){
                        
                        $user = $manager->findByUsername($username);
                        Session::setUser($user);
                        Session::addFlash("success", "Vous êtes connectés, bienvenue !");
                        header('Location:index.php');
                        die();
                    }
                    else{
                        Session::addFlash("error", "Le mot de passe est faux !");
                    } 
                }
                else{
                    Session::addFlash("error", "Le pseudo ou le mot de passe sont manquants.");
                }
            }
            return [
                "view" => VIEW_DIR."login.php"
            ];
        }
        
        public function register(){
            if(!empty($_POST)){

                $username = filter_input(INPUT_POST, "username", FILTER_VALIDATE_REGEXP,
                    array(
                        "options" => array("regexp"=>'/[A-Za-z0-9]{4,}/')
                    )
                );
                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $pass = filter_input(INPUT_POST, "pass", FILTER_VALIDATE_REGEXP,
                    array(
                        "options" => array("regexp"=>'/[A-Za-z0-9]{6,32}/')
                    )
                );
                $passrepeat = filter_input(INPUT_POST, "pass-r", FILTER_SANITIZE_STRING);

                if($username && $email){
                    if($pass){
                        if($pass === $passrepeat){
                            //embeter la base de données
                            $manager = new UserManager();
                            $tab = $manager->checkUserExists($email);  
                            if(in_array(0, $tab)){
                                $user = [
                                    "username" => $username,
                                    "email" => $email,
                                    "password" => password_hash($pass, PASSWORD_ARGON2I),
                                ];
                                $manager->add($user); 
                                Session::addFlash("success", "Inscription réussie, connectez-vous !");
                                header('Location:index.php?ctrl=security&action=login');
                                die();
                            }
                            else{
                                Session::addFlash("error", "Cet e-mail existe déjà !");
                            }
                        }
                        else{
                            Session::addFlash("error", "Les deux mots de passe ne correspondent pas.");
                        }
                    }
                    else{
                        Session::addFlash("error", "Le mot de passe est invalide.");
                    }
                }
                else{
                    Session::addFlash("error", "Le pseudo ou l'email sont vides.");
                }
            }
            return [
                "view" => VIEW_DIR."register.php"
            ];
        }
        
        public function logout(){
            Session::setUser(null);
            Session::addFlash("success", "A bientôt !");
            header('Location:index.php');
            die();
        }
    }
