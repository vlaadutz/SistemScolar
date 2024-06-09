        <div class="container">
            <div class="jumbotron">
                <center>
                    <h1>Sistem Scolar</h1>
                    <p>
                        Acest sistem are ca scop preluarea datelor despre elevi din municipiul Bucuresti si judetul Ilfov.
                        <br>
                        Prin intermediul acestei aplicatii, vor fi administrate date personale, cat si situatia scolara a fiecarui elev.
                    </p>

                    <?php if ($autentificat === false): ?>
                        <a href="<?php echo $url . "autentificare"; ?>" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                                <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                            </svg>
                            Autentificare
                        </a>
                    <?php endif; ?>

                    <?php if ($autentificat): ?>
                        <a href="<?php echo $url . "panou_control_elevi"; ?>" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-fill" viewBox="0 0 16 16">
                                <path d="M3.904 1.777C4.978 1.289 6.427 1 8 1s3.022.289 4.096.777C13.125 2.245 14 2.993 14 4s-.875 1.755-1.904 2.223C11.022 6.711 9.573 7 8 7s-3.022-.289-4.096-.777C2.875 5.755 2 5.007 2 4s.875-1.755 1.904-2.223"/>
                                <path d="M2 6.161V7c0 1.007.875 1.755 1.904 2.223C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777C13.125 8.755 14 8.007 14 7v-.839c-.457.432-1.004.751-1.49.972C11.278 7.693 9.682 8 8 8s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972"/>
                                <path d="M2 9.161V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13s3.022-.289 4.096-.777C13.125 11.755 14 11.007 14 10v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972"/>
                                <path d="M2 12.161V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972"/>
                            </svg>
                            Acceseaza Portal Sistem
                        </a>
                    <?php endif; ?>
                </center>
            </div>

            <hr>

            <center>
                <h2>Date in timp real</h2>
                <p>Vizualizeaza situatia scolara a elevilor in timp real prin grafice si reprezentari vizuale.</p>

                <div id="grafic-demo"></div>
            </center>

            <hr>
            
            <center>
                <h2>Administrare ca la carte</h2>
                <p>Toate informatiile intr-un singur loc, la un click distanta.</p>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h4>Elevi</h4>
                            </div>

                            <div class="card-body" style="height: 300px">
                                Date importante, cat si medii si statistici sunt toate prezente intr-un sistem modern de administrare.
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profesori</h4>
                            </div>

                            <div class="card-body" style="height: 300px">
                                Informatii importante despre profesorii, precum date personale si de contact.
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h4>Taxe</h4>
                            </div>

                            <div class="card-body" style="height: 300px">
                                Vizualizeaza date concrete despre bursele de merit alocate fiecarui elev. Bursele sunt afisate intr-un mod grafic, organizat pe fiecare sector al Bucurestiului.
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h4>Rapoarte</h4>
                            </div>

                            <div class="card-body" style="height: 300px">
                                Rapoarte ce reprezinta situatia scolara generala intr-un anumit judet si/sau oras. Util pentru date de referinta.
                            </div>
                        </div>
                    </div>
                </div>
            </center>
        </div>

        <br>

        <blockquote class="blockquote text-center bg-light">
            <small>© 2024</small>
            <div class="blockquote-footer">
                <small>made with ♥ Mihaescu Mihai-Vlad. CNIH</small>
            </div>
                
        </blockquote>

        <!-- GRAFIC PENTRU DEMO -->
        <script>
            $("document").ready(function() {
                $("#grafic-demo").highcharts({
                    chart: {
						type: 'column',
						options3d: {
							enabled: true,
							alpha: 15,
							beta: 15,
							depth: 50,
							viewDistance: 25
						}
                    },

                    title: {
                        text: "Statistici Popescu Ion"
                    },

                    series: [
                        {
                            name: "Matematica",
                            data: [8]
                        },
                        {
                            name: "Lb. Romana",
                            data: [9]
                        },
                        {
                            name: "Informatica",
                            data: [10]
                        },
                        {
                            name: "Fizica",
                            data: [8]
                        },
                        {
                            name: "Biologie",
                            data: [8]
                        },
                        {
                            name: "Chimie",
                            data: [7]
                        },
                    ]
                });
            });
        </script>
    </body>
</html>
