<?php
    namespace Controller;

    use App\Session;
    use Model\Managers\UserManager;
    
    class HomeController{

        public function index(){
            Session::authenticationRequired();
            return [
                "view" => VIEW_DIR."home.php",
                "data" => [
                    
                ]
            ];
        }

        public function secure(){
            Session::authenticationRequired();
            return [
                "view" => VIEW_DIR."secure.php",
                "data" => [
                    
                ]
            ];
        }

        public function users(){

            $manager = new UserManager();
            $users = $manager->findAll();

            return [
                "view" => VIEW_DIR."users.php",
                "data" => [
                    "users" => $users
                ]
            ];
        }

        /*public function ajax(){
            $nb = $_GET['nb'];
            $nb++;
            include(VIEW_DIR."ajax.php");
        }*/
    }
