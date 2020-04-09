<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Entities\User;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";

        public function __construct(){
            parent::connect();
        }

        public function checkUserExists($email){
            $sql = "SELECT COUNT(u.id)
                    FROM ".$this->tableName." u
                    WHERE u.email = :email
                    ";

            return DAO::select($sql, ['email' => $email]);
        }

        public function retrievePassword($username){
            $sql = "SELECT u.password
                    FROM ".$this->tableName." u
                    WHERE u.username = :username
                    ";

            return DAO::select($sql, ['username' => $username]);
        }

        public function findByUsername($username){

            $sql = "SELECT *
                    FROM ".$this->tableName." u
                    WHERE u.username = :username
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['username' => $username], false), 
                $this->className
            );
        }

    }