<?php
    class Profesor extends CI_Model
    {
        /**
         * Preluare date profesor
         * 
         * @param String $profesor
         * 
         * @return array
         */
        function preluare_date($profesor)
        {
            $this -> load -> database();            
            return $this -> db -> get_where("profesori", array("profesorID" => $profesor)) -> result();
        }

        /**
         * Preluare date toti profesorii
         * 
         * @return void
         */
        function preluare_toti()
        {
            $this -> load -> database();
            return $this -> db -> get("profesori") -> result();
        }

        /**
         * Validare date
         * 
         * @return boolean
         */
        function validare()
        {
            $this -> load -> library("form_validation");

            $this -> form_validation -> set_rules("materie", "Materie", "required");
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
         * Adaugare date profesor in baza de date
         * 
         * @param String $materie
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
        function adaugare($materie, $sex, $nume, $prenume, $adresa, $telefon, $email, $dataNasterii, $dataInregistrarii, $judet, $oras)
        {
            $materie = $this -> db -> escape_str($this -> input -> post("materie"));
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

            $this -> db -> insert("Profesori", array("materieID" => $materie, "sex" => $sex, "nume" => $nume, "prenume" => $prenume, "adresa" => $adresa, "telefon" => $telefon, "email" => $email, "dataNasterii" => $dataNasterii, "dataInregistrarii" => $dataInregistrarii, "judetID" => $judet, "orasID" => $oras));
        }

        /**
         * Actualizare date profesor in baza de date
         * 
         * @param String $profesor
         * @param String $materie
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
        function actualizare($profesor, $materie, $sex, $nume, $prenume, $adresa, $telefon, $email, $dataNasterii, $dataInregistrarii, $judet, $oras)
        {
            $this -> load -> database();

            $materie = $this -> db -> escape_str($this -> input -> post("materie"));
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

            $this -> db -> update("profesori", array("materieID" => $materie, "sex" => $sex, "nume" => $nume, "prenume" => $prenume, "adresa" => $adresa, "telefon" => $telefon, "email" => $email, "dataNasterii" => $dataNasterii, "dataInregistrarii" => $dataInregistrarii, "judetID" => $judet, "orasID" => $oras), array("profesorID" => $profesor));
        }

        /**
         * Stergere date profesor din baza de date
         * 
         * @param String $profesor
         * 
         * @return void
         */
        function stergere($profesor)
        {
            $this -> load -> database();
            $this -> db -> delete("profesori", array("profesorID" => $profesor));
        }
    }