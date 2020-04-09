<?php
    namespace Model\Entities;

    use App\Entity;

    final class Vehicule extends Entity{

        private $id;
        private $immat;
        private $modele;
        private $couleurs;
        private $marque;
        private $dateajout;
        private $birth;
        private $image;

        public function __construct($data){         
            $this->hydrate($data);        
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
            return $this->id;
        }

        protected function setId($id){

            $this->id = $id;

            return $this;
        }

        /**
         * Get the value of immat
         */ 
        public function getImmat()
        {
            return $this->immat;
        }

        /**
         * Set the value of immat, formatted like this : XX-000-XX
         *
         * @return  self
         */ 
        public function setImmat($immat)
        {
            $immat = substr_replace($immat,'-',2,0);
            $immat = substr_replace($immat,'-',6,0);
            $this->immat = $immat;

            return $this;
        }

        /**
         * Get the value of modele
         */ 
        public function getModele()
        {
            return $this->modele;
        }

        /**
         * Set the value of modele
         *
         * @return  self
         */ 
        public function setModele($modele)
        {
            $this->modele = $modele;

            return $this;
        }

        /**
         * Get the value of couleurs
         */ 
        public function getCouleurs($index = null)
        {
            if($index !== null){
                return $this->couleurs[$index];
            }
            else return $this->couleurs;
        }

        /**
         * Set the value of couleurs
         *
         * @return  self
         */ 
        public function setCouleurs($couleurs)
        {
            $this->couleurs = json_decode($couleurs);

            return $this;
        }

        /**
         * Get the value of marque
         */ 
        public function getMarque()
        {
                return $this->marque;
        }

        /**
         * Set the value of marque
         *
         * @return  self
         */ 
        public function setMarque($marque)
        {
                $this->marque = $marque;

                return $this;
        }

        /**
         * Get the value of dateajout
         */ 
        public function getDateajout()
        {
                return $this->dateajout;
        }

        /**
         * Set the value of dateajout
         *
         * @return  self
         */ 
        public function setDateajout($dateajout)
        {
                $this->dateajout = $dateajout;
                $this->setBirth(30);
                return $this;
        }

        /**
         * Get the value of image
         */ 
        public function getImage()
        {
                return $this->image;
        }

        /**
         * Set the value of image
         *
         * @return  self
         */ 
        public function setImage($image)
        {
                $this->image = $image;

                return $this;
        }
        
        public function __toString(){

            return $this->immat." - ".$this->marque->getNom()." ".$this->modele;
        }


        /**
         * Get the value of birth
         */ 
        public function getBirth()
        {
                return $this->birth;
        }

        /**
         * Set the value of birth
         *
         * @return  self
         */ 
        public function setBirth($birth)
        {
            $this->birth = $birth;
        }
    }
