<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Enlace a Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="./public/css/estiloreportes.css">

<div>
    <div class="row" id="PanelReporteMedicos">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-4 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Perfil del Equipo de Desarrollo</h2>
                        </div>                         
                        <div class="col-sm-8 p-0 d-flex justify-content-end align-items-center">
                            <a href="#" class="btn btn-success ocultar-en-impresion mr-2" id="BtnVolver">
                                <i class="material-icons">arrow_back</i> <span>Regresar</span>
                            </a>
                        </div>    
                    </div>
                </div> <br>
                
                <div class="row">
                    <!-- Tarjeta 1: Reina Maribel Mejía Martínez -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card text-center card-hover">
                            <div class="card-body">
                                <img src="public/img/iconoperfil.png" alt="Reina Maribel Mejía Martínez" class="img-fluid" style="width: 80px; height: 80px; border-radius: 50%;">
                                <h5 class="card-title">Reina Maribel Mejía Martínez</h5>
                                <p class="card-text">Reina es una colaboradora apasionada y comprometida, cuya visión es contribuir a un ambiente de trabajo positivo. Su capacidad para trabajar en equipo la convierte en un pilar fundamental en el desarrollo de proyectos.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2: Liliana de los Ángeles Monge Cerón -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card text-center card-hover">
                            <div class="card-body">
                                <img src="public/img/iconoperfil.png" alt="Liliana de los Ángeles Monge Cerón" class="img-fluid" style="width: 80px; height: 80px; border-radius: 50%;">
                                <h5 class="card-title">Liliana de los Ángeles Monge Cerón</h5>
                                <p class="card-text">Liliana es una profesional con una fuerte ética de trabajo y un compromiso inquebrantable con el éxito del equipo. Su enfoque en la colaboración y la comunicación ayuda a fomentar un ambiente donde todos pueden prosperar.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 3: Karla Lourdes Leiva -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card text-center card-hover">
                            <div class="card-body">
                                <img src="public/img/iconoperfil.png" alt="Karla Lourdes Leiva" class="img-fluid" style="width: 80px; height: 80px; border-radius: 50%;">
                                <h5 class="card-title">Karla Lourdes Leiva</h5>
                                <p class="card-text">Karla es una profesional dedicada y comprometida, enfocada en trabajar en equipo para lograr objetivos comunes y contribuir al éxito de los proyectos. Siempre dispuesta a enfrentar nuevos retos y colaborar con soluciones efectivas.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 4: Gabriela Lucía Delgado Mejía -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card text-center card-hover">
                            <div class="card-body">
                                <img src="public/img/iconoperfil.png" alt="Gabriela Lucía Delgado Mejía" class="img-fluid" style="width: 80px; height: 80px; border-radius: 50%;">
                                <h5 class="card-title">Gabriela Lucía Delgado Mejía</h5>
                                <p class="card-text">Gabriela es una miembro del equipo dedicada y entusiasta, que se enfoca en alcanzar los objetivos del grupo. Su capacidad para adaptarse a diferentes situaciones y su deseo de aprender constantemente son rasgos que la distinguen.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Al hacer clic en el botón "Regresar"
    $("#BtnVolver").click(function() {
        // Cargar el contenido del archivo principal en #sub-data
        $("#sub-data").load("./views/ayuda/principal.php");
        return false; // Evitar la acción por defecto del enlace
    });
</script>

<style>
    .table-wrapper {
        overflow-x: hidden; /* Ocultar el scroll horizontal */
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, box-shadow 0.3s; /* Transición para el efecto de hover */
    }
    
    .card-hover:hover {
        transform: scale(1.05); /* Aumentar el tamaño de la tarjeta */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Efecto de sombra más intensa */
    }

    /* Estilo para evitar la capitalización de texto */
    .card-title, .card-text {
        text-transform: none; /* Asegura que no haya transformación de texto */
    }
</style>
