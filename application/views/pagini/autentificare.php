        <div class="container">
            <h2>Autentifica-te in contul tau</h2>
        
            <form action="" method="POST">
                <input type="hidden" name="incercat" value="1">
                <input class="form-control" type="text" name="nume" placeholder="Nume utilizator" required>
                <br>
                <input class="form-control" type="password" name="parola" placeholder="Parola" required>
                <br>
                <input class="btn btn-success" type="submit" value="Intra in cont">
            </form>
        </div>

        <?php if(isset($eroareLogin)): ?>
            <script>
                Swal.fire({title: "Toate campurile sunt obligatorii!", icon: "error"});
            </script>
        <?php endif; ?>
    </body>
</html>