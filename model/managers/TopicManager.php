<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";

        public function __construct(){
            parent::connect();
        }

        public function lockTopic($idtopic, $closeState){
            
            $sql = "UPDATE topic SET closed = :close WHERE id_topic = :id";

            return $this->getSingleScalarResult(
                DAO::update($sql, ['close' => $closeState, 'id' => $idtopic])
            );
        }

    }