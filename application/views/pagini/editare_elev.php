<div class="container">
	<div id="elevi" class="card">
		<div class="container">
			<form action="" method="POST">
				<label for="clasa">Clasa:</label>
				<select id="cmbClasa" class="form-control" name="clasa">
					<?php foreach($clasePreluate as $clasa): ?>
						<option value="<?php echo $clasa -> clasaID; ?>"><?php echo $clasa -> numeClasa; ?></option>
					<?php endforeach; ?>
				</select>

				<br>

				<label for="sex">Sex:</label>
				<br>
				<input type="radio" name="sex" value="1" required> Masculin
				<input type="radio" name="sex" value="0" required> Feminin

				<br>
				<br>

				<label for="nume">Nume:</label>
				<input id="txtNume" class="form-control" type="text" name="nume" value="<?php echo $dateElevVechi[0] -> nume ?>" required>

				<br>

				<label for="prenume">Prenume:</label>
				<input id="txtPrenume" class="form-control" type="text" name="prenume" value="<?php echo $dateElevVechi[0] -> prenume ?>" required>

				<br>

				<label for="adresa">Adresa:</label>
				<input id="txtAdresa" class="form-control" type="text" name="adresa" value="<?php echo $dateElevVechi[0] -> adresa ?>" required>

				<br>

				<label for="telefon">Telefon:</label>
				<input id="txtTelefon" class="form-control" type="text" name="telefon" value="<?php echo $dateElevVechi[0] -> telefon ?>" required>

				<br>

				<label for="email">Email:</label>
				<input id="txtEmail" class="form-control" type="email" name="email" value="<?php echo $dateElevVechi[0] -> email ?>" required>

				<br>

				<label for="dataNasterii">Data nasterii:</label>
				<input id="dataNasterii" class="form-control" type="date" name="dataNasterii" value="<?php echo $dateElevVechi[0] -> dataNasterii ?>" required>

				<br>

				<label for="dataInregistrarii">Data inregistrarii:</label>
				<input id="dataInregistrarii" class="form-control" type="date" name="dataInregistrarii" value="<?php echo $dateElevVechi[0] -> dataInregistrarii ?>" required>

				<br>

				<label for="judet">Judet:</label>
				<select class="form-control" name="judet">
					<?php foreach($judetePreluate as $judet): ?>
						<option value="<?php echo $judet -> judetID; ?>"><?php echo $judet -> numeJudet; ?></option>
					<?php endforeach; ?>
				</select>

				<br>

				<label for="clasa">Oras:</label>
				<select class="form-control" name="oras">
					<?php foreach($orasePreluate as $oras): ?>
						<option value="<?php echo $oras -> orasID; ?>"><?php echo $oras -> numeOras; ?></option>
					<?php endforeach; ?>
				</select>

				<br>

				<input type="submit" class="btn btn-success" value="Salveaza datele">
				<a href="sterge_elev/<?php echo $dateElevVechi[0] -> elevID; ?>" class="btn btn-danger">Sterge elev</a>
			</form>
		</div>
		<br>
	</div>
	<br>
</div>
</body>
</html>
