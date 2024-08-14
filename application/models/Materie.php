<?php
    class Materie extends CI_Model
    {
        /**
         * Preluare toate materiile din baza de date
         * 
         * @return array
         */
        function preluare_toate()
        {
            $this -> load -> database();
            return $this -> db -> get("materii") -> result();
        }
    }