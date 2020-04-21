<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
            
        }
        public function viewTopic($idtopic){
            $this->restrictTo("ROLE_USER");
            
            $topicManager = new TopicManager();
            $topic = $topicManager->findOneById($idtopic);
            
            $postManager = new PostManager();
            $posts = $postManager->findByTopic($idtopic);

            return [
                "view" => VIEW_DIR."viewTopic.php",
                "data" => [
                    "topic" => $topic,
                    "posts" => $posts
                ]
            ];
        }
        
        public function addTopic(){
            $this->restrictTo("ROLE_USER");
            
            if(!empty($_POST)){

                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
                $firstpost = filter_input(INPUT_POST, "firstpost", FILTER_SANITIZE_STRING);

                if($title && $firstpost){
                    $iduser = Session::getUser()->getId();
                    $topicManager = new TopicManager();
                    
                    //ajout du topic
                    $idtopic = $topicManager->add([
                        "title" => $title,
                        "user_id" => $iduser
                    ]);
                    $this->newPost($firstpost, $idtopic);
                    
                    Session::addFlash("success", "Nouveau sujet ajouté avec succès !");
                    $this->redirectTo("forum", "viewTopic", $idtopic);
                }
                else{
                    Session::addFlash("error", "Un problème est survenu, veuillez réessayer.");
                } 

                $this->redirectTo("home");
            }
            
            return [
                "view" => VIEW_DIR."newTopic.php"
            ];
        }

        public function addPost($idtopic){
            $this->restrictTo("ROLE_USER");
            
            if(!empty($_POST)){

                $post = filter_input(INPUT_POST, "post", FILTER_SANITIZE_STRING);

                if($post){
                    
                    $this->newPost($post, $idtopic);
                    Session::addFlash("success", "Nouveau message ajouté !");
                    $this->redirectTo("forum", "viewTopic", $idtopic);
                }
                else{
                    Session::addFlash("error", "Un problème est survenu, veuillez réessayer.");
                } 
                
            }
            $this->redirectTo("forum", "viewTopic", $idtopic);
        }

        private function newPost($post, $idtopic){
            $postManager = new PostManager();
            //ajout du premier post grâce à l'id du topic récupérée
            if($postManager->add([
                    "text" => $post,
                    "user_id" => Session::getUser()->getId(),
                    "topic_id" => $idtopic
                ])){
                Session::addFlash("success", "Nouveau message ajouté avec succès !");
                return true;
            }
            else{
                Session::addFlash("error", "Echec de l'ajout de message !");
            }  
            return false;
        }

        public function editPost($idpost){
            $this->restrictTo("ROLE_USER");
            $postManager = new PostManager();
            $post = $postManager->findOneById($idpost);
            if(!empty($_POST)){

                $newtext = filter_input(INPUT_POST, "newtext", FILTER_UNSAFE_RAW);

                if($newtext){
                    
                    $postManager->updatePost($idpost, $newtext);
                    
                    Session::addFlash("success", "Message modifié !");
                    $this->redirectTo("forum", "viewTopic", $post->getTopic()->getId());
                }
                else{
                    Session::addFlash("error", "Un problème est survenu, veuillez réessayer.");
                }
            }
            $topic = $post->getTopic();
        
            $posts = $postManager->findByTopic($topic->getId());

            return [
                "view" => VIEW_DIR."viewTopic.php",
                "data" => [
                    "topic"        => $topic,
                    "posts"        => $posts,
                    "postIdToEdit" => $idpost
                ]
            ];
        }

        public function deleteTopic($idtopic){
            $this->restrictTo("ROLE_USER");
            $topicManager = new TopicManager();
            if($topicManager->delete($idtopic)){
                Session::addFlash("success", "Sujet supprimé !");
                $this->redirectTo("home");
            }
            $this->redirectTo("forum", "viewTopic", $idtopic);
        }

        public function lockTopic($idtopic){
         
            if(isset($_GET['source'])){
                $source = $_GET['source'];
            }
            $topicManager = new TopicManager();
            $topic = $topicManager->findOneById($idtopic);
            if(Session::getUser() == $topic->getUser()){
                $closeState = ($topic->getClosed() == 1) ? 0 : 1;
                $topicManager->lockTopic($idtopic, $closeState);
                $closeMsg = ($closeState == 1) ? "verrouillé" : "déverrouillé";
                Session::addFlash("success", "Ce sujet est désormais $closeMsg !");
            }
            if($source == "list"){
                $this->redirectTo("home");
            }
            $this->redirectTo("forum", "viewTopic", $idtopic);

        }


    }
