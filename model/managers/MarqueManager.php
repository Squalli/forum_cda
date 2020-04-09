<?php
    namespace Model\Managers;
        
    use App\Manager;
    use Model\Entities\Marque;

    class MarqueManager extends Manager{

        protected $className = "Model\Entities\Marque";
        protected $tableName = "marque";

        public function __construct(){
            parent::connect();
        }

        /*public function findAll(){
            return parent::findAll();
        }

        public function findOneById($id){
            return parent::findOneById($id);
        }*/
    }