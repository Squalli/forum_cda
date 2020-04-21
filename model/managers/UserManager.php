<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";

        public function __construct(){
            parent::connect();
        }

        public function checkUserExists($email){
            $sql = "SELECT COUNT(u.id_user)
                    FROM ".$this->tableName." u
                    WHERE u.email = :email
                    ";

            return $this->getSingleScalarResult(
                DAO::select($sql, ['email' => $email], false)
            );
        }

        public function retrievePassword($email){
            $sql = "SELECT u.password
                    FROM ".$this->tableName." u
                    WHERE u.email = :email
                    ";

            return $this->getSingleScalarResult(
                DAO::select($sql, ['email' => $email], false)
            );
        }

        public function findByEmail($email){

            $sql = "SELECT id_user, username, email, registerdate, roles
                    FROM ".$this->tableName." u
                    WHERE u.email = :email
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }

    }