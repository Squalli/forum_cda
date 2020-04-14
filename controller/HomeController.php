<?php


    namespace Controller;

    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    use Model\Managers\TopicManager;
    
    class HomeController extends AbstractController implements ControllerInterface{

        public function index(){
            $this->restrictTo("ROLE_USER");
            
            $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."home.php",
                "data" => [
                    "topics" => $topicManager->findAll(["creationdate", "DESC"])
                ]
            ];
        }

        public function users(){
            $this->restrictTo("ROLE_USER");

            $manager = new UserManager();
            $users = $manager->findAll(['username', 'ASC']);

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
