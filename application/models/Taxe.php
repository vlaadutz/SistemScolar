<?php
    class Taxe extends CI_Model
    {
        /**
         * Preluare date despre burse/taxe
         * 
         * @return array
         */
        function preluare_date()
        {
            $this -> load -> database();
            return $this -> db -> query("SELECT Burse.bursa AS bursa, Orase.numeOras AS numeOras FROM Burse JOIN Orase on Burse.orasID = Orase.orasID;") -> result();
        }
    }