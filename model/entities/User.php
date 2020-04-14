<?php
    namespace Model\Entities;

    use App\Entity;

    final class User extends Entity{

        private $id;
        private $username;
        private $email;
        private $registerdate;
        private $roles = [];

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

        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        public function getRegisterdate(){
            $formattedDate = $this->registerdate->format("d/m/Y");
            return $formattedDate;
        }

        public function setRegisterdate($registerdate){
            $this->registerdate = new \DateTime($registerdate);
            return $this;
        }

        public function getRoles(){
            if(empty($this->roles)){
                return ['ROLE_USER'];
            }
            return $this->roles;
        }

        public function setRoles($role){
            $this->roles[] = $role;
        }

        public function hasRole($role){
            return in_array($role, $this->getRoles());
        }

        public function __toString(){
            return $this->username;
        }
    }
