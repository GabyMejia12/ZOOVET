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
                            <h2 class="ml-lg-2">Videos del Sistema</h2>
                        </div>                         
                        <div class="col-sm-8 p-0 d-flex justify-content-end align-items-center">
                            <a href="#" class="btn btn-success ocultar-en-impresion mr-2" id="BtnVolver">
                                <i class="material-icons">arrow_back</i> <span>Regresar</span>
                            </a>
                            
                        </div>    
                    </div>
                </div> <br>
                <div class="table-responsive" id="DataPanelProductos">
                    <div id="contenedorManuales">
                        <!-- Tarjetas de videos -->
                        <div class="tarjeta-manual">
                            <div class="icono"><i class="material-icons">video_library</i></div>
                            <h3>Cómo Iniciar Sesión</h3>
                            <p>Aprende a iniciar sesión en el sistema.</p>
                            <a href="ruta/a/video_iniciar_sesion.mp4" class="btn btn-success" target="_blank">
                                <span>Ver Video</span>
                            </a>
                        </div>

                        <div class="tarjeta-manual">
                            <div class="icono"><i class="material-icons">video_library</i></div>
                            <h3>Cómo Registrar un Usuario</h3>
                            <p>Guía para registrar nuevos usuarios en el sistema.</p>
                            <a href="ruta/a/video_registrar_usuario.mp4" class="btn btn-success" target="_blank">
                                <span>Ver Video</span>
                            </a>
                        </div>

                        <div class="tarjeta-manual">
                            <div class="icono"><i class="material-icons">video_library</i></div>
                            <h3>Cómo Actualizar Módulos</h3>
                            <p>Instrucciones para actualizar los módulos del sistema.</p>
                            <a href="ruta/a/video_actualizar_modulos.mp4" class="btn btn-success" target="_blank">
                                <span>Ver Video</span>
                            </a>
                        </div>

                        <div class="tarjeta-manual">
                            <div class="icono"><i class="material-icons">video_library</i></div>
                            <h3>Cómo Eliminar un Registro</h3>
                            <p>Pasos para eliminar registros en el sistema.</p>
                            <a href="ruta/a/video_eliminar.mp4" class="btn btn-success" target="_blank">
                                <span>Ver Video</span>
                            </a>
                        </div>

                        <div class="tarjeta-manual">
                            <div class="icono"><i class="material-icons">video_library</i></div>
                            <h3>Cómo Ver Reportes</h3>
                            <p>Guía sobre cómo acceder a los reportes del sistema.</p>
                            <a href="ruta/a/video_ver_reportes.mp4" class="btn btn-success" target="_blank">
                                <span>Ver Video</span>
                            </a>
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