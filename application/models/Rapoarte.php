<?php
    class Rapoarte extends CI_Model
    {
        /**
         * Preluare date rapoarte din baza de date
         * 
         * @return array
         */
        function preluare_date()
        {
            return array(
                "peste5B" => $this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 1 AND Medii.medie >= 5;") -> result(),
                "peste5IF" => $this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 2 AND Medii.medie >= 5;") -> result(),
                "sub5B" => $this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 1 AND Medii.medie < 5;") -> result(),
                "sub5IF" => $this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 2 AND Medii.medie < 5;") -> result(),
                "B10" => $this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 1 AND Medii.medie = 10;") -> result(),
                "IF10" => $this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 2 AND Medii.medie = 10;") -> result()
            );
        }
    }