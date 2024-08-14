<?php
    class Pagini extends CI_Controller
    {
        function index()
        {
			$this -> load -> helper("url");
			header("Location: " . base_url() . "acasa");
        }

        function acasa()
        {
            $this -> load -> helper("url");
            $this -> load -> library("session");

            // daca e autentificat
            $date = array("url" => base_url(), "autentificat" => false);
            if (isset($this -> session -> numeUtilizator))
            {
                $date["autentificat"] = true;
            }

            $this -> load -> view("sabloane/header.php", $date);
            $this -> load -> view("pagini/acasa");
        }
        
        function autentificare()
        {
            $this -> load -> helper("url");
            $this -> load -> library("session");
            $this -> load -> library("form_validation");

            // date pagina
            $date = array("url" => base_url(), "autentificat" => false);

            // verificare login
            $this -> form_validation -> set_rules("nume", "Nume", "required");
            $this -> form_validation -> set_rules("parola", "Parola", "required");
            $rezultat_validare = $this -> form_validation -> run();
            if ($rezultat_validare === true)
            {
                // verificare db
                $this -> load -> database();
                $nume = $this -> db -> escape_str($this -> input -> post("nume"));
                $parola = $this -> db -> escape_str($this -> input -> post("parola"));

                $rezultat_query = $this -> db -> get_where("Utilizatori", array("nume" => $nume, "parola" => $parola));
                if (count($rezultat_query -> result()))
                {
                    $this -> session -> numeUtilizator = $rezultat_query -> result()[0] -> nume;
                }
            }
            else
            {
                if (isset($_POST["incercat"]))
                {
                    $date["eroareLogin"] = 1;
                }
            }

            // afisare pagina
            if (isset($this -> session -> numeUtilizator) === false)
            {
                $this -> load -> view("sabloane/header.php", $date);
                $this -> load -> view("pagini/autentificare.php");
            }
            else
            {
                header("Location: " . base_url() . "panou_control_elevi");
            }
        }

        function panou_control_elevi()
        {
            $this -> load -> helper("url");
            $this -> load -> library("session");
			$this -> load -> model("Elev");
			$this -> load -> model("Dropdown");

            if ($this -> Elev -> validare_date())
            {
                $this -> Elev -> adaugare_date($this -> input -> post("clasa"), $this -> input -> post("sex"), $this -> input -> post("nume"), $this -> input -> post("prenume"), $this -> input -> post("adresa"), $this -> input -> post("telefon"), $this -> input -> post("email"), $this -> input -> post("dataNasterii"), $this -> input -> post("dataInregistrarii"), $this -> input -> post("judet"), $this -> input -> post("oras"));
            }

            $date = array(
				"url" => base_url(), 
				"autentificat" => false,
				"clasePreluate" => $this -> Dropdown -> preluare_clase_judete_orase()["clasePreluate"],
				"judetePreluate" => $this -> Dropdown -> preluare_clase_judete_orase()["judetePreluate"],
				"orasePreluate" => $this -> Dropdown -> preluare_clase_judete_orase()["orasePreluate"]
			);

            if (isset($this -> session -> numeUtilizator))
            {
                $date["autentificat"] = true;
                $this -> load -> view("sabloane/header.php", $date);
                $this -> load -> view("pagini/panou_control_elevi.php", $date);
            }
            else
            {
                header("Location: " . base_url() . "autentificare");
            }
        } 

        function tabel_elevi()
        {
            $this -> load -> library("session");
            $this -> load -> library("form_validation");
            $this -> load -> helper("url");
			$this -> load -> model("Elev");
            $this -> load -> database();

            // verificare nume cautat
            $seCauta = false;
            $elevi = array();
            $this -> form_validation -> set_rules("nume", "Nume", "required");
            if ($this -> form_validation -> run())
            {
                $nume = $this -> db -> escape_str($this -> input -> post("nume"));
                $elevi = ($this -> db -> query("SELECT * FROM elevi WHERE nume LIKE('" . $nume . "%');")) -> result();

                $seCauta = true;
            }

            if (isset($this -> session -> numeUtilizator))
            {
                if ($seCauta == false)
                {
                    $elevi = $this -> Elev -> preluare_toti();
                }
                $date = array("url" => base_url(), "autentificat" => true, "elevi" => $elevi);
                $this -> load -> view("sabloane/header.php", $date);
                $this -> load -> view("pagini/tabel_elevi.php");
            }
            else
            {
                header("Location: " . base_url() . "autentificare");
            }
        }

		function editare_elev($elev = "E")
		{
			$this -> load -> helper("url");
			$this -> load -> library("session");
			$this -> load -> model("Elev");
			$this -> load -> model("Dropdown");

			if ($this -> Elev -> validare_date())
			{
				$this -> Elev -> actualizare_date($elev, $this -> input -> post("clasa"), $this -> input -> post("sex"), $this -> input -> post("nume"), $this -> input -> post("prenume"), $this -> input -> post("adresa"), $this -> input -> post("telefon"), $this -> input -> post("email"), $this -> input -> post("dataNasterii"), $this -> input -> post("dataInregistrarii"), $this -> input -> post("judet"), $this -> input -> post("oras"));				
			}

			if ($elev != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					// preluare date vechi pt a fi completare in campuri
					$dateElevVechi = $this -> Elev -> preluare_date($elev);

					if (count($dateElevVechi) != 0)
					{
						$date = array(
							"url" => base_url(), 
							"autentificat" => true,
							"dateElevVechi" => $dateElevVechi,
							"clasePreluate" => $this -> Dropdown -> preluare_clase_judete_orase()["clasePreluate"],
							"judetePreluate" => $this -> Dropdown -> preluare_clase_judete_orase()["judetePreluate"],
							"orasePreluate" => $this -> Dropdown -> preluare_clase_judete_orase()["orasePreluate"]
						);

						$this -> load -> view("sabloane/header.php", $date);
						$this -> load -> view("pagini/editare_elev", $date);
					}
					else
					{
						show_404();
					}
				}
				else
				{
					header("Location: " . base_url() . "autentificare");
				}
			}
			else
			{
				show_404();
			}
		}

		function stergere_elev($elev = "E")
		{
			$this -> load -> library("session");
			$this -> load -> model("Elev");

			if ($elev != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					$this -> Elev -> stergere($elev);
				}
				else
				{
					header("Location: " . base_url() . "autentificare");
				}
			}
			else
			{
				show_404();
			}
		}

		function statistici_elev($elev = "E")
		{
			$this -> load -> helper("url");
			$this -> load -> library("session");
			$this -> load -> library("form_validation");
			$this -> load -> model("Elev");
			$this -> load -> model("Medie");
			$this -> load -> model("Materie");
			
			if ($this -> Medie -> validare())
			{
				$materie = $this -> input -> post("materie");
				$medie = $this -> input -> post("medie");

				if ($this -> Medie -> exista($elev, $materie))
				{
					$this -> Medie -> actualizare($elev, $materie, $medie);
				}
				else
				{
					$this -> Medie -> adaugare($elev, $materie, $medie);
				}
			}

			if ($elev != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					$date = array("url" => base_url(), "autentificat" => true);
					$date["numeElev"] = $this -> Elev -> preluare_date($elev);
					$date["materiiPreluate"] = $this -> Materie -> preluare_toate();
					$date["mediiPreluate"] = $this -> Medie -> preluare_elev($elev);

					$this -> load -> view("sabloane/header.php", $date);
					$this -> load -> view("pagini/statistici_elev", $date);
				}
				else
				{
					header("Location: " . base_url() . "autentificare");
				}
			}
			else
			{
				show_404();
			}
		}

		function stergere_medii($elev = "E")
		{
			$this -> load -> helper("url");
			$this -> load -> library("session");
			$this -> load -> model("Medie");

			if ($elev != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					$this -> Medie -> stergere($elev);
					header("Location: " . base_url() . "acasa");
				}
				else
				{
					header("Location: " . base_url() . "autentificare");
				}
			}
			else
			{
				show_404();
			}
		}

		function panou_control_profesori()
        {
            $this -> load -> helper("url");
            $this -> load -> library("session");
			$this -> load -> model("Dropdown");
			$this -> load -> model("Profesor");
			
			if ($this -> Profesor -> validare())
			{
				$this -> Profesor -> adaugare($this -> input -> post("materie"), $this -> input -> post("sex"), $this -> input -> post("nume"), $this -> input -> post("prenume"), $this -> input -> post("adresa"), $this -> input -> post("telefon"), $this -> input -> post("email"), $this -> input -> post("dataNasterii"), $this -> input -> post("dataInregistrarii"), $this -> input -> post("judet"), $this -> input -> post("oras"));
			}

            if (isset($this -> session -> numeUtilizator))
            {
                $date = array(
					"url" => base_url(), 
					"autentificat" => true,
					"materiiPreluate" => $this -> Dropdown -> preluare_materii_clase_judete_orase()["materiiPreluate"],
					"clasePreluate" => $this -> Dropdown -> preluare_materii_clase_judete_orase()["clasePreluate"],
					"judetePreluate" => $this -> Dropdown -> preluare_materii_clase_judete_orase()["judetePreluate"],
					"orasePreluate" => $this -> Dropdown -> preluare_materii_clase_judete_orase()["orasePreluate"]
				);

                $this -> load -> view("sabloane/header.php", $date);
                $this -> load -> view("pagini/panou_control_profesori.php");
            }
            else
            {
                header("Location: " . base_url() . "autentificare");
            }
        }

		function tabel_profesori()
		{
			$this -> load -> library("session");
			$this -> load -> library("form_validation");
			$this -> load -> helper("url");
			$this -> load -> model("Profesor");
			$this -> load -> database();

			// verificare nume cautat
			$seCauta = false;
			$profesori = array();
			$this -> form_validation -> set_rules("nume", "Nume", "required");
			if ($this -> form_validation -> run())
			{
				$nume = $this -> db -> escape_str($this -> input -> post("nume"));
				$profesori = ($this -> db -> query("SELECT * FROM Profesori WHERE nume LIKE('" . $nume . "%');")) -> result();

				$seCauta = true;
			}

			if (isset($this -> session -> numeUtilizator))
			{
				if ($seCauta == false)
				{
					$profesori = $this -> Profesor -> preluare_toti();
				}
				$date = array("url" => base_url(), "autentificat" => true, "profesori" => $profesori);
				$this -> load -> view("sabloane/header.php", $date);
				$this -> load -> view("pagini/tabel_profesori.php");
			}
			else
			{
				header("Location: " . base_url() . "autentificare");
			}
		}

		function editare_profesor($profesor = "E")
		{
			$this -> load -> library("session");
			$this -> load -> library("form_validation");
			$this -> load -> helper("url");
			$this -> load -> model("Profesor");
			$this -> load -> model("Dropdown");

			if ($this -> Profesor -> validare())
			{
				$this -> Profesor -> actualizare($profesor, $this -> input -> post("materie"), $this -> input -> post("sex"), $this -> input -> post("nume"), $this -> input -> post("prenume"), $this -> input -> post("adresa"), $this -> input -> post("telefon"), $this -> input -> post("email"), $this -> input -> post("dataNasterii"), $this -> input -> post("dataInregistrarii"), $this -> input -> post("judet"), $this -> input -> post("oras"));
			}

			if ($profesor != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					// preluare date vechi si completare in campuri
					$dateProfesorVechi = $this -> Profesor -> preluare_date($profesor);

					if (count($dateProfesorVechi) != 0)
					{
						$date = array(
							"url" => base_url(), 
							"autentificat" => true,
							"materiiPreluate" => $this -> Dropdown -> preluare_materii_clase_judete_orase()["materiiPreluate"],
							"judetePreluate" => $this -> Dropdown -> preluare_materii_clase_judete_orase()["judetePreluate"],
							"orasePreluate" => $this -> Dropdown -> preluare_materii_clase_judete_orase()["orasePreluate"],
							"dateProfesorVechi" => $dateProfesorVechi
						);

						$this -> load -> view("sabloane/header.php", $date);
						$this -> load -> view("pagini/editare_profesor", $date);
					}
					else
					{
						show_404();
					}
				}
				else
				{
					header("Location: " . base_url() . "autentificare");
				}
			}
			else
			{
				show_404();
			}
		}

		function stergere_profesor($profesor = "E")
		{
			$this -> load -> library("session");
			$this -> load -> model("Profesor");

			if ($profesor != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					$this -> Profesor -> stergere($profesor);
					header("Location: " . base_url() . "acasa");
				}
				else
				{
					header("Location: " . base_url() . "autentificare");
				}
			}
			else
			{
				show_404();
			}
		}

		function panou_control_taxe()
		{
			$this -> load -> library("session");
			$this -> load -> helper("url");
			$this -> load -> model("Taxe");

			if (isset($this -> session -> numeUtilizator))
			{
				$date = array(
					"url" => base_url(), 
					"autentificat" => true,
					"burse" => $this -> Taxe -> preluare_date()
				);

				$this -> load -> view("sabloane/header", $date);
				$this -> load -> view("pagini/panou_control_taxe");
			}
			else
			{
				header("Location: " . base_url() . "autentificare");
			}
		}

		function panou_control_rapoarte()
		{
			$this -> load -> library("session");
			$this -> load -> helper("url");
			$this -> load -> database();
			$this -> load -> model("Rapoarte");

			if (isset($this -> session -> numeUtilizator))
			{
				$date = array(
					"url" => base_url(), 
					"autentificat" => true,
					"peste5B" => $this -> Rapoarte -> preluare_date()["peste5B"],
					"peste5IF" => $this -> Rapoarte -> preluare_date()["peste5IF"],
					"sub5B" => $this -> Rapoarte -> preluare_date()["sub5B"],
					"sub5IF" => $this -> Rapoarte -> preluare_date()["sub5IF"],
					"B10" => $this -> Rapoarte -> preluare_date()["B10"],
					"IF10" => $this -> Rapoarte -> preluare_date()["IF10"],
				);

				$this -> load -> view("sabloane/header.php", $date);
				$this -> load -> view("pagini/panou_control_rapoarte.php");
			}
			else
			{
				header("Location: " . base_url() . "autentificare");
			}
		}
    }
