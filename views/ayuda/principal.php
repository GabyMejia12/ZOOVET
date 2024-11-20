<!-- Enlace a Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="./public/css/estiloreportes.css">
<div id="contenedorReportes">
    
    <!-- Tarjeta de usuarios -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">local_library</i></div> <!-- Ícono de inventario -->
        <h3>Manual de los usuarios</h3>
        <p>Consulta las guías y documentos que te ayudarán a entender las funciones y procedimientos básicos en el sistema, diseñado especialmente para el personal de la veterinaria.</p>
        <a href="#" class="btn btn-success" id="panel-manual-usuarios">
            <span>Ver más</span>
        </a>
    </div>

    <!-- Tarjeta de administrador -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">admin_panel_settings</i></div> <!-- Ícono de entrada -->
        <h3>Manual del administrador</h3>
        <p>Encuentra el manual completo del administrador general, con instrucciones detalladas para gestionar el sistema de manera eficiente y segura. <br><br></p>
        <a href="#" class="btn btn-success" id="panel-manual-admin">
            <span>Ver más</span>
        </a>
    </div>

    <!-- Tarjeta de videos -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">movie</i></div> <!-- Ícono de salida -->
        <h3>Tutoriales <br>del <br>sistema</h3>
        <p>Accede a videos de orientación que explican paso a paso las distintas funcionalidades del sistema, ideales para usuarios nuevos y en capacitación.</p>
        <a href="#" class="btn btn-success" id="panel-videos">
            <span>Ver más</span>
        </a>
    </div>

    <!-- Tarjeta de perfiles -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">diversity_3</i></div> <!-- Ícono de inventario -->
        <h3>Acerca <br>del <br>equipo</h3>
        <p>Conoce a los miembros del equipo de soporte y desarrollo que respaldan el sistema, <br>incluyendo sus perfiles y roles dentro del proyecto. <br><br></p>
        <a href="#" class="btn btn-success" id="panel-perfiles">
            <span>Ver más</span>
        </a>
    </div>

</div>


<script>
    $(document).ready(function() {
        $("#panel-manual-usuarios").click(function() {
            $("#sub-data").load("./views/ayuda/manual_usuarios.php");
            return false;
        });
        $("#panel-manual-admin").click(function() {
            $("#sub-data").load("./views/ayuda/manual_admin.php");
            return false;
        });
        $("#panel-videos").click(function() {
            $("#sub-data").load("./views/ayuda/videos_sistema.php");
            return false;
        });
        
        $("#panel-perfiles").click(function() {
            $("#sub-data").load("./views/ayuda/perfil_equipo.php");
            return false;
        });        
    });
</script>

