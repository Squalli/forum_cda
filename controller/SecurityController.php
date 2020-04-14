<?php
    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    
    class SecurityController extends AbstractController implements ControllerInterface{

        public function index(){

            $this->redirectTo("security", "login");
        }
        
        public function login(){
            if(!empty($_POST)){

                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_REGEXP,
                    array(
                        "options" => array("regexp"=>'/[A-Za-z0-9]{4,}/')
                    )
                );
                $pass = filter_input(INPUT_POST, "pass", FILTER_VALIDATE_REGEXP,
                    array(
                        "options" => array("regexp"=>'/[A-Za-z0-9]{6,32}/')
                    )
                );

                if($email && $pass){
                    $manager = new UserManager();
                    $dbPass = $manager->retrievePassword($email);
                    if(password_verify($pass, $dbPass)){
                        
                        $user = $manager->findByEmail($email);
                        Session::setUser($user);
                        Session::addFlash("success", "Vous êtes connectés, bienvenue !");
                        $this->redirectTo("home");
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
                            if(!$manager->checkUserExists($email)){
                                $manager->add([
                                    "username" => $username,
                                    "email"    => $email,
                                    "password" => password_hash($pass, PASSWORD_ARGON2I),
                                ]); 
                                Session::addFlash("success", "Inscription réussie, connectez-vous !");
                                $this->redirectTo("security", "login");
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
