        <div class="container">
            <form action="" method="POST">
                <label for="nume">Cauta elev dupa numele de familie: </label>
                <input class="form-control" type="text" name="nume">
                <br>
                <input class="btn btn-success" type="submit" value="Cauta">
            </form>    

            <br>
            <br>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <td><b>ID Elev</b></td>
                        <td><b>Sex</b></td>
                        <td><b>Nume</b></td>
                        <td><b>Prenume</b></td>
                        <td><b>Adresa</b></td>
                        <td><b>Telefon</td>
                        <td><b>Email</b></td>
                        <td><b>Data nasterii</b></td>
                        <td><b>Data inregistrarii</b></td>
                        <td><b>Clasa</b></td>
                        <td><b>ID Oras</b></td>
						<td><b>ID Judet</b></td>
						<td><b>Statistici</b></td>
                    </tr>
                </thead>    

                <?php foreach ($elevi as $elev): ?>
                    <tr>
						<td><a href="editare_elev/<?php echo $elev -> elevID; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16"><path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/></svg></a><?php echo $elev -> elevID ?></td>
                        <td><?php echo $elev -> sex ?></td>
                        <td><?php echo $elev -> nume ?></td>
                        <td><?php echo $elev -> prenume ?></td>
                        <td><?php echo $elev -> adresa ?></td>
                        <td><?php echo $elev -> telefon ?></td>
                        <td><?php echo $elev -> email ?></td>
                        <td><?php echo $elev -> dataNasterii ?></td>
                        <td><?php echo $elev -> dataInregistrarii ?></td>
                        <td><?php echo $elev -> clasaID ?></td>
                        <td><?php echo $elev -> orasID ?></td>
                        <td><?php echo $elev -> judetID ?></td>
						<td><a class="btn btn-primary" href="statistici_elev/<?php echo $elev -> elevID;?>">Vizualizare</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
