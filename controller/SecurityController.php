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

                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
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
                "view" => VIEW_DIR."security/login.php"
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
                                    "username" => strtolower($username),
                                    "email"    => strtolower($email),
                                    "password" => password_hash($pass, PASSWORD_ARGON2I),
                                    "roles"    => json_encode(['ROLE_USER'])
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
                "view" => VIEW_DIR."security/register.php"
            ];
        }
        
        public function logout(){
            $this->restrictTo("ROLE_USER");

            Session::setUser(null);
            Session::addFlash("success", "A bientôt !");
            $this->redirectTo("home");
        }

        public function viewProfile($iduser = null){
            $this->restrictTo("ROLE_USER");
            
            $userManager = new UserManager();
            if($iduser !== null){
                $user = $userManager->findOneById($iduser);
            }
            else $user = Session::getUser();

            return [
                "view" => VIEW_DIR."security/profile.php",
                "data" => [
                    "user" => $user
                ]
            ];
        }
    }
