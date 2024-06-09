<div id="grafic-medii"></div>

<div class="container">
	<h2>Adauga/modifica medie</h2>

	<hr>

	<form method="post" action="">
		<label for="materie">Materie</label>
		<select id="cmbMaterie" class="form-control" name="materie">
			<?php foreach($materiiPreluate as $materie): ?>
				<option value="<?php echo $materie -> materieID; ?>"><?php echo $materie -> nume; ?></option>
			<?php endforeach; ?>
		</select>
		
		<br>

		<label for="medie">Medie</label>
		<input class="form-control" type="number" name="medie" required>

		<br>

		<input class="btn btn-success" type="submit" value="Salveaza">
		<a class="btn btn-danger" href="/index.php/pagini/stergere_medii/<?php echo $numeElev[0] -> elevID; ?>">Sterge toate mediile</a>
	</form>
</div>

<script>
	$("document").ready(function () {
		$("#grafic-medii").highcharts({
			chart: {
				type: "column"
			},

			title: {
				text: "Statistici <?php echo $numeElev[0] -> nume . ' ' . $numeElev[0] -> prenume; ?>"
			},

			series:  [
				<?php foreach ($mediiPreluate as $medie): ?>
					{
						name: "<?php echo $medie -> numeMaterie ?>",
						data: [<?php echo $medie -> medie ?>]
					},
				<?php endforeach; ?>
			]
		});
	});
</script>
