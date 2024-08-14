<?php
    class Dropdown extends CI_Model
    {
        /**
         * Preluare date dropdown (Clase, Judete, Orase)
         * 
         * @return array
         */
        function preluare_clase_judete_orase()
        {
            $this -> load -> database();
            
            return array(
                "clasePreluate" => $this -> db -> get("clase") -> result(),
                "judetePreluate" => $this -> db -> get("judete") -> result(),
                "orasePreluate" => $this -> db -> get("orase") -> result()
            );
        }

        /**
         * Preluare date dropdown (Materii, Clase, Judete, Orase)
         * 
         * @return array
         */
        function preluare_materii_clase_judete_orase()
        {
            $this -> load -> database();
            
            return array(
                "materiiPreluate" => $this -> db -> get("materii") -> result(),
                "clasePreluate" => $this -> db -> get("clase") -> result(),
                "judetePreluate" => $this -> db -> get("judete") -> result(),
                "orasePreluate" => $this -> db -> get("orase") -> result()
            );
        }
    }