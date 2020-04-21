<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";

        public function __construct(){
            parent::connect();
        }

        public function findByTopic($idtopic){

            $sql = "SELECT *
                    FROM ".$this->tableName." p
                    WHERE topic_id = :topicid";

            return $this->getMultipleResults(
                DAO::select($sql, ['topicid' => $idtopic]), 
                $this->className
            );
        }

        public function updatePost($idpost, $newtext){

            $sql = "UPDATE ".$this->tableName." SET text = :newtext WHERE id_post = :id";

            return DAO::update($sql, ['newtext' => $newtext, 'id' => $idpost]);

        }

    }