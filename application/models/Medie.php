<?php
    class Medie extends CI_Model
    {
        /**
         * Validare medie
         * 
         * @return boolean
         */
        function validare()
        {
            $this -> load -> library("form_validation");

            $this -> form_validation -> set_rules("medie", "Medie", "required");
            return $this -> form_validation -> run();
        }

        /**
         * Verificare daca media pentru materia respectiva exista
         * 
         * @param String $elev
         * @param String $materie
         * 
         * @return boolean
         */
        function exista($elev, $materie)
        {
            $this -> load -> database();
            return count($this -> db -> get_where("medii", array("elevID" => $elev, "materieID" => $materie)) -> result()) > 0;
        }

        /**
         * Adaugare medie elev pentru materie
         * 
         * @param String $elev
         * @param String $materie
         * @param String $medie
         * 
         * @return void
         */
        function adaugare($elev, $materie, $medie)
        {
            $this -> load -> database();
            $this -> db -> insert("medii", array("elevID" => $elev, "materieID" => $materie, "medie" => $medie));
        }

        /**
         * Actualizare medie elev pentru materie
         * 
         * @param String $elev
         * @param String $materie
         * @param String $medie
         * 
         * @return void
         */
        function actualizare($elev, $materie, $medie)
        {
            $this -> load -> database();
            $this -> db -> update("medii", array("medie" => $medie), array("elevID" => $elev, "materieID" => $materie));
        }

        /**
         * Stergere medii pentru toate materiile unui elev din baza de date
         * 
         * @param String $elev
         * 
         * @return void
         */
        function stergere($elev)
        {
            $this -> load -> database();
            $this -> db -> delete("medii", array("elevID" => $elev));
        }

        /**
         * Preluarea tuturor mediilor pentru un elev
         * 
         * @param String $elev
         * 
         * @return array
         */
        function preluare_elev($elev)
        {
            $this -> load -> database();
            return $this -> db -> query("SELECT Materii.nume AS numeMaterie, Medii.medie AS medie FROM Materii JOIN Medii ON Medii.materieID = Materii.materieID WHERE Medii.elevID = {$elev}") -> result();
        }
    }