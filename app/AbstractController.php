<?php
    namespace App;

    abstract class AbstractController{

        public function index(){}
        
        public function redirectTo($ctrl = null, $action = null, $id = null){

            $url = "index.php?ctrl=$ctrl&action=$action&id=$id";

            header("Location: $url");
            die();

        }

        public function restrictTo($role){
            
            if(!Session::getUser() || !Session::getUser()->hasRole($role)){
                header("Location:index.php?ctrl=security&action=login");
                die();
            }
            return;
        }

    }