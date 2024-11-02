<!-- Enlace a Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="./public/css/estiloreportes.css">

<div id="contenedorReportes">
    <!-- Tarjeta de Productos -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">inventory_2</i></div> <!-- Ícono de inventario -->
        <h3>Productos</h3>
        <p>Reporte completo de productos registrados.</p>
        <a href="#" class="btn btn-success" id="panel-reporte-productos">
            <span>Generar Reporte</span>
        </a>
    </div>

    <!-- Tarjeta de Entradas -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">input</i></div> <!-- Ícono de entrada -->
        <h3>Entradas</h3>
        <p>Reporte de todas las entradas registradas.</p>
        <a href="#" class="btn btn-success" id="panel-reporte-entradas">
            <span>Generar Reporte</span>
        </a>
    </div>

    <!-- Tarjeta de Salidas -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">output</i></div> <!-- Ícono de salida -->
        <h3>Salidas</h3>
        <p>Reporte de todas las salidas registradas.</p>
        <a href="#" class="btn btn-success" id="panel-reporte-salidas">
            <span>Generar Reporte</span>
        </a>
    </div>

    <!-- Tarjeta de Inventarios -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">inventory</i></div> <!-- Ícono de inventario -->
        <h3>Inventarios</h3>
        <p>Reporte completo del inventario actual.</p>
        <a href="#" class="btn btn-success" id="panel-reporte-inventario">
            <span>Generar Reporte</span>
        </a>
    </div>

    <!-- Tarjeta de Médicos -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">local_hospital</i></div> <!-- Ícono de médicos -->
        <h3>Médicos</h3>
        <p>Médicos registrados en el sistema.</p>
        <a href="#" class="btn btn-success" id="panel-reporte-medicos">
            <span>Generar Reporte</span>
        </a>
    </div>
    

    <!-- Tarjeta de Mascotas -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">pets</i></div> <!-- Ícono de mascotas -->
        <h3>Mascotas</h3>
        <p>Informe sobre las mascotas atendidas.</p>
        <a href="#" class="btn btn-success" id="panel-reporte-mascotas">
            <span>Generar Reporte</span>
        </a>
    </div>

    <!-- Tarjeta de Consultas -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">medical_services</i></div> <!-- Ícono de consultas -->
        <h3>Consultas</h3>
        <p>Reporte detallado de consultas realizadas.</p>
        <a href="#" class="btn btn-success" id="panel-reporte-consultas">
            <span>Generar Reporte</span>
        </a>
    </div>

       

    <!-- Tarjeta de Campañas -->
    <div class="reporte-card">
        <div class="icono"><i class="material-icons">campaign</i></div> <!-- Ícono de campañas -->
        <h3>Campañas</h3>
        <p>Reporte de campañas realizadas.</p>
        <a href="#" class="btn btn-success" id="panel-reporte-campañas">
            <span>Generar Reporte</span>
        </a>
    </div>
</div>



<script>
    $(document).ready(function() {
        $("#panel-reporte-productos").click(function() {
            $("#sub-data").load("./views/reportes/reporte_productos.php");
            return false;
        });
        $("#panel-reporte-entradas").click(function() {
            $("#sub-data").load("./views/reportes/reporte_entradas.php");
            return false;
        });
        $("#panel-reporte-salidas").click(function() {
            $("#sub-data").load("./views/reportes/reporte_salidas.php");
            return false;
        });
        
        $("#panel-reporte-inventario").click(function() {
            $("#sub-data").load("./views/reportes/reporte_inventario.php");
            return false;
        });
        $("#panel-reporte-medicos").click(function() {
            $("#sub-data").load("./views/reportes/reporte_medicos.php");
            return false;
        });
        $("#panel-reporte-mascotas").click(function() {
            $("#sub-data").load("./views/reportes/reporte_mascotas.php");
            return false;
        }); 
        $("#panel-reporte-consultas").click(function() {
            $("#sub-data").load("./views/reportes/reporte_consultas.php");
            return false;
        });        
                
        $("#panel-reporte-campañas").click(function() {
            $("#sub-data").load("./views/reportes/reporte_campañas.php");
            return false;
        });
    });
</script>
