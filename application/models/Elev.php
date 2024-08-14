<?php
    class Elev extends CI_Model
    {
        /**
         * Preluare date elev
         * 
         * @param String $elev
         * 
         * @return array
         */
        function preluare_date($elev)
        {
            $this -> load -> database();

            return $this -> db -> get_where("elevi", array("elevID" => $elev)) -> result();
        }

        /**
         * Preluare date toti elevii
         * 
         * @return array
         */
        function preluare_toti()
        {
            $this -> load -> database();
            return $this -> db -> get("elevi") -> result();
        }

        /**
         * Validare date elev
         * 
         * @return boolean
         */
        function validare_date()
        {
            $this -> load -> library("form_validation");

            $this -> form_validation -> set_rules("clasa", "Clasa", "required");
            $this -> form_validation -> set_rules("sex", "Sex", "required");
            $this -> form_validation -> set_rules("nume", "Nume", "required");
            $this -> form_validation -> set_rules("prenume", "Prenume", "required");
            $this -> form_validation -> set_rules("adresa", "Adresa", "required");
            $this -> form_validation -> set_rules("telefon", "Telefon", "required");
            $this -> form_validation -> set_rules("email", "Email", "required");
            $this -> form_validation -> set_rules("dataNasterii", "Data Nasterii", "required");
            $this -> form_validation -> set_rules("dataInregistrarii", "Data Inregistrarii", "required");
            $this -> form_validation -> set_rules("judet", "Judet", "required");
            $this -> form_validation -> set_rules("oras", "Oras", "required");

            return $this -> form_validation -> run();
        }
        
        /**
         * Adaugare date elev in baza de date
         * 
         * @param String $clasa
         * @param String $sex
         * @param String $nume
         * @param String $prenume
         * @param String $adresa
         * @param String $telefon
         * @param String $email
         * @param String $dataNasterii
         * @param String $dataInregistrarii
         * @param String $judet
         * @param String $oras
         * 
         * @return void
         */
        function adaugare_date($clasa, $sex, $nume, $prenume, $adresa, $telefon, $email, $dataNasterii, $dataInregistrarii, $judet, $oras)
        {
            $this -> load -> database();

            $clasa = $this -> db -> escape_str($this -> input -> post("clasa"));
            $sex = $this -> db -> escape_str($this -> input -> post("sex"));
            $nume = $this -> db -> escape_str($this -> input -> post("nume"));
            $prenume = $this -> db -> escape_str($this -> input -> post("prenume"));
            $adresa = $this -> db -> escape_str($this -> input -> post("adresa"));
            $telefon = $this -> db -> escape_str($this -> input -> post("telefon"));
            $email = $this -> db -> escape_str($this -> input -> post("email"));
            $dataNasterii = $this -> db -> escape_str($this -> input -> post("dataNasterii"));
            $dataInregistrarii = $this -> db -> escape_str($this -> input -> post("dataInregistrarii"));
            $judet = $this -> db -> escape_str($this -> input -> post("judet"));
            $oras = $this -> db -> escape_str($this -> input -> post("oras"));

            $this -> db -> insert("Elevi", array("clasaID" => $clasa, "sex" => $sex, "nume" => $nume, "prenume" => $prenume, "adresa" => $adresa, "telefon" => $telefon, "email" => $email, "dataNasterii" => $dataNasterii, "dataInregistrarii" => $dataInregistrarii, "judetID" => $judet, "orasID" => $oras));
        }

        /**
         * Actualizare date elev in baza de date
         * 
         * @param String $elev
         * @param String $clasa
         * @param String $sex
         * @param String $nume
         * @param String $prenume
         * @param String $adresa
         * @param String $telefon
         * @param String $email
         * @param String $dataNasterii
         * @param String $dataInregistrarii
         * @param String $judet
         * @param String $oras
         * 
         * @return void
         */
        function actualizare_date($elev, $clasa, $sex, $nume, $prenume, $adresa, $telefon, $email, $dataNasterii, $dataInregistrarii, $judet, $oras)
        {
            $this -> load -> database();

            $clasa = $this -> db -> escape_str($this -> input -> post("clasa"));
            $sex = $this -> db -> escape_str($this -> input -> post("sex"));
            $nume = $this -> db -> escape_str($this -> input -> post("nume"));
            $prenume = $this -> db -> escape_str($this -> input -> post("prenume"));
            $adresa = $this -> db -> escape_str($this -> input -> post("adresa"));
            $telefon = $this -> db -> escape_str($this -> input -> post("telefon"));
            $email = $this -> db -> escape_str($this -> input -> post("email"));
            $dataNasterii = $this -> db -> escape_str($this -> input -> post("dataNasterii"));
            $dataInregistrarii = $this -> db -> escape_str($this -> input -> post("dataInregistrarii"));
            $judet = $this -> db -> escape_str($this -> input -> post("judet"));
            $oras = $this -> db -> escape_str($this -> input -> post("oras"));

            $this -> db -> update("Elevi", array("clasaID" => $clasa, "sex" => $sex, "nume" => $nume, "prenume" => $prenume, "adresa" => $adresa, "telefon" => $telefon, "email" => $email, "dataNasterii" => $dataNasterii, "dataInregistrarii" => $dataInregistrarii, "judetID" => $judet, "orasID" => $oras), array("elevID" => $elev));
        }

        /**
         * Stergere elev din baza de date
         * 
         * @param String $elev
         * 
         * @return void
         */
        function stergere($elev)
        {
            $this -> load -> database();
            $this -> db -> delete("elevi", array("elevID" => $elev));
        }
    }