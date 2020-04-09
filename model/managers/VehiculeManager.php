<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Entities\Vehicule;

    class VehiculeManager extends Manager{

        protected $className = "Model\Entities\Vehicule";
        protected $tableName = "vehicule";

        public function __construct(){
            parent::connect();
        }

        /*
        public function findAll(){
            return parent::findAll();
        }
        
        public function findOneById($id){
            return parent::findOneById($id);
        }
        */
        
        public function count(){

            $sql = "SELECT COUNT(*), marque_id
                    FROM ".$this->tableName." a
                    GROUP BY marque_id
                    ";

            return DAO::select($sql);
        }

        public function findByMarque($idmarque){
            $sql = "SELECT *
                    FROM ".$this->tableName." v WHERE v.marque_id = :id
                    ";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $idmarque]), 
                $this->className
            );
        }
        
        public function delete($id){
            $result = parent::delete($id);
            if($result == true){
                return "Le véhicule n°".$id." a été supprimé avec succès";
            }
        }

    }