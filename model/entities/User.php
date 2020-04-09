<?php
    namespace Model\Entities;

    use App\Entity;

    final class User extends Entity{

        private $id;
        private $username;
        private $email;
        private $registerdate;

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        public function getId() {
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function getUsername(){
            return $this->username;
        }

        public function setUsername($username){
            $this->username = $username;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of registerdate
         */ 
        public function getRegisterdate()
        {
                return $this->registerdate;
        }

        /**
         * Set the value of registerdate
         *
         * @return  self
         */ 
        public function setRegisterdate($registerdate)
        {
                $this->registerdate = $registerdate;

                return $this;
        }
    }
