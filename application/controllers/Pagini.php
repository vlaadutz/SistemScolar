<?php
    class Pagini extends CI_Controller
    {
        function index()
        {
            $this -> acasa();
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
                $this -> panou_control_elevi();
            }
        }

        function panou_control_elevi()
        {
            $this -> load -> helper("url");
            $this -> load -> library("session");
            $this -> load -> library("form_validation");
            $this -> load -> database();

            // validare date elev
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
            if ($this -> form_validation -> run())
            {
				// adaugare date elev dupa validare
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

            $date = array("url" => base_url(), "autentificat" => false);

            // preluare date pentru dropdown
            $clasePreluate = ($this -> db -> get("Clase")) -> result();
            $judetePreluate = ($this -> db -> get("Judete")) -> result();
            $orasePreluate = ($this -> db -> get("Orase")) -> result();
            $date["clasePreluate"] = $clasePreluate;
            $date["judetePreluate"] = $judetePreluate;
            $date["orasePreluate"] = $orasePreluate;

            if (isset($this -> session -> numeUtilizator))
            {
                $date["autentificat"] = true;
                $this -> load -> view("sabloane/header.php", $date);
                $this -> load -> view("pagini/panou_control_elevi.php", $date);
            }
            else
            {
                $this -> autentificare();
            }
        } 

        function tabel_elevi()
        {
            $this -> load -> library("session");
            $this -> load -> library("form_validation");
            $this -> load -> helper("url");
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
                    $elevi = ($this -> db -> get("elevi")) -> result();
                }
                $date = array("url" => base_url(), "autentificat" => true, "elevi" => $elevi);
                $this -> load -> view("sabloane/header.php", $date);
                $this -> load -> view("pagini/tabel_elevi.php");
            }
            else
            {
                $this -> autentificare();
            }
        }

		function editare_elev($elev = "E")
		{
			$this -> load -> library("session");
			$this -> load -> library("form_validation");
			$this -> load -> helper("url");
			$this -> load -> database();
			$this -> load -> library("session");

			// validare date elev
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

			if ($this -> form_validation -> run())
			{
				// actualizare date elev dupa validare
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

			if ($elev != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					// preluare date vechi si completare in campuri
					$dateElevVechi = ($this -> db -> get_where("Elevi", array("elevID" => $elev))) -> result();

					if (count($dateElevVechi) != 0)
					{
						$date = array("url" => base_url(), "autentificat" => true);
						$date["clasePreluate"] = ($this -> db -> get("clase")) -> result();
						$date["judetePreluate"] = ($this -> db -> get("judete")) -> result();
						$date["orasePreluate"] = ($this -> db -> get("orase")) -> result();
						$date["dateElevVechi"] = $dateElevVechi;

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
					$this -> autentificare();
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
			$this -> load -> database();

			if ($elev != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					$this -> db -> delete("elevi", array("elevID" => $elev));
				}
				else
				{
					$this -> autentificare();
				}
			}
			else
			{
				show_404();
			}
		}

		function statistici_elev($elev = "E")
		{
			$this -> load -> library("session");
			$this -> load -> library("form_validation");
			$this -> load -> helper("url");
			$this -> load -> database();
			$this -> load -> library("session");

			$this -> form_validation -> set_rules("medie", "Medie", "required");
			if ($this -> form_validation -> run())
			{
				$materie = $this -> input -> post("materie");
				$medie = $this -> input -> post("medie");

				// daca media deja exista in tabel se actualizeaza
				$exista = ($this -> db -> get_where("medii", array("elevID" => $elev, "materieID" => $materie))) -> result();
				if (count($exista) > 0)
				{
					$this -> db -> update("medii", array("medie" => $medie), array("elevID" => $elev, "materieID" => $materie));
				}
				else
				{
					$this -> db -> insert("medii", array("elevID" => $elev, "materieID" => $materie, "medie" => $medie));
				}
			}

			if ($elev != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					$date = array("url" => base_url(), "autentificat" => true);
					$date["numeElev"] = ($this -> db -> query("SELECT elevID, nume, prenume FROM Elevi WHERE elevID = {$elev}")) -> result();
					$date["materiiPreluate"] = ($this -> db -> get("materii")) -> result();
					$date["mediiPreluate"] = ($this -> db -> query("SELECT Materii.nume AS numeMaterie, Medii.medie AS medie FROM Materii JOIN Medii ON Medii.materieID = Materii.materieID WHERE Medii.elevID = {$elev}")) -> result();

					$this -> load -> view("sabloane/header.php", $date);
					$this -> load -> view("pagini/statistici_elev", $date);
				}
				else
				{
					$this -> autentificare();
				}
			}
			else
			{
				show_404();
			}
		}

		function stergere_medii($elev = "E")
		{
			$this -> load -> library("session");
			$this -> load -> database();

			if ($elev != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					$this -> db -> delete("medii", array("elevID" => $elev));
					$this -> index();
				}
				else
				{
					$this -> autentificare();
				}
			}
			else
			{
				show_404();
			}
		}

		function panou_control_profesori()
        {
            $this -> load -> database();
            $this -> load -> helper("url");
            $this -> load -> library("session");
            $this -> load -> library("form_validation");

			// validare date profesor
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
			if ($this -> form_validation -> run())
			{
				// adaugare date profesor dupa validare
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

            if (isset($this -> session -> numeUtilizator))
            {
                $date = array("url" => base_url(), "autentificat" => true);

				// preluare date pentru dropdown
				$materiiPreluate = ($this -> db -> get("Materii")) -> result();
				$clasePreluate = ($this -> db -> get("Clase")) -> result();
				$judetePreluate = ($this -> db -> get("Judete")) -> result();
				$orasePreluate = ($this -> db -> get("Orase")) -> result();
				$date["materiiPreluate"] = $materiiPreluate;
				$date["clasePreluate"] = $clasePreluate;
				$date["judetePreluate"] = $judetePreluate;
				$date["orasePreluate"] = $orasePreluate;

                $this -> load -> view("sabloane/header.php", $date);
                $this -> load -> view("pagini/panou_control_profesori.php");
            }
            else
            {
                $this -> autentificare();
            }
        }

		function tabel_profesori()
		{
			$this -> load -> library("session");
			$this -> load -> library("form_validation");
			$this -> load -> helper("url");
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
					$profesori = ($this -> db -> get("Profesori")) -> result();
				}
				$date = array("url" => base_url(), "autentificat" => true, "profesori" => $profesori);
				$this -> load -> view("sabloane/header.php", $date);
				$this -> load -> view("pagini/tabel_profesori.php");
			}
			else
			{
				$this -> autentificare();
			}
		}

		function editare_profesor($profesor = "E")
		{
			$this -> load -> library("session");
			$this -> load -> library("form_validation");
			$this -> load -> helper("url");
			$this -> load -> database();
			$this -> load -> library("session");

			// validare date profesor
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

			if ($this -> form_validation -> run())
			{
				// actualizare date profesor dupa validare
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

			if ($profesor != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					// preluare date vechi si completare in campuri
					$dateProfesorVechi = ($this -> db -> get_where("Profesori", array("profesorID" => $profesor))) -> result();

					if (count($dateProfesorVechi) != 0)
					{
						$date = array("url" => base_url(), "autentificat" => true);
						$date["materiiPreluate"] = ($this -> db -> get("materii")) -> result();
						$date["judetePreluate"] = ($this -> db -> get("judete")) -> result();
						$date["orasePreluate"] = ($this -> db -> get("orase")) -> result();
						$date["dateProfesorVechi"] = $dateProfesorVechi;

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
					$this -> autentificare();
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
			$this -> load -> database();

			if ($profesor != "E")
			{
				if (isset($this -> session -> numeUtilizator))
				{
					$this -> db -> delete("profesori", array("profesorID" => $profesor));
					$this -> index();
				}
				else
				{
					$this -> autentificare();
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
			$this -> load -> database();

			if (isset($this -> session -> numeUtilizator))
			{
				$date = array("url" => base_url(), "autentificat" => true);
				$date["burse"] = ($this -> db -> query("SELECT Burse.bursa AS bursa, Orase.numeOras AS numeOras FROM Burse JOIN Orase on Burse.orasID = Orase.orasID;")) -> result();

				$this -> load -> view("sabloane/header", $date);
				$this -> load -> view("pagini/panou_control_taxe");
			}
			else
			{
				$this -> autentificare();
			}
		}

		function panou_control_rapoarte()
		{
			$this -> load -> library("session");
			$this -> load -> helper("url");
			$this -> load -> database();

			if (isset($this -> session -> numeUtilizator))
			{
				$date = array("url" => base_url(), "autentificat" => true);

				// preluare date statistici
				$peste5B = ($this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 1 AND Medii.medie >= 5;")) -> result();
				$peste5IF = ($this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 2 AND Medii.medie >= 5;")) -> result();
				$sub5B = ($this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 1 AND Medii.medie < 5;")) -> result();
				$sub5IF = ($this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 2 AND Medii.medie < 5;")) -> result();
				$B10 = ($this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 1 AND Medii.medie = 10;")) -> result();
				$IF10 = ($this -> db -> query("SELECT COUNT(Medii.medieID) AS medie FROM Medii JOIN Elevi ON Elevi.elevID = Medii.elevID WHERE Elevi.judetID = 2 AND Medii.medie = 10;")) -> result();

				$date["peste5B"] = $peste5B;
				$date["peste5IF"] = $peste5IF;
				$date["sub5B"] = $sub5B;
				$date["sub5IF"] = $sub5IF;
				$date["B10"] = $B10;
				$date["IF10"] = $IF10;

				$this -> load -> view("sabloane/header.php", $date);
				$this -> load -> view("pagini/panou_control_rapoarte.php");
			}
			else
			{
				$this -> autentificare();
			}
		}
    }
