<?php
@session_start();
ini_set('display_errors', 1);
date_default_timezone_set('America/El_Salvador');
include './models/conexion.php';
include './controllers/controllersFunciones.php';

$conn = conectar_db();

$query = "SELECT COUNT(*) AS total_mascotas FROM mascota";
$result = $conn->query($query);
$total_mascotas = 0;

if ($result && $row = $result->fetch_assoc()) {
    $total_mascotas = $row['total_mascotas'];
}

$query = "SELECT COUNT(*) AS total_medicos FROM veterinario";
$result = $conn->query($query);
$total_medicos = 0;

if ($result && $row = $result->fetch_assoc()) {
    $total_medicos = $row['total_medicos'];
}

$query = "SELECT COUNT(*) AS total_consultas FROM consultas";
$result = $conn->query($query);
$total_consultas = 0;

if ($result && $row = $result->fetch_assoc()) {
    $total_consultas = $row['total_consultas'];
}

$query = "SELECT COUNT(*) AS total_productos FROM productos";
$result = $conn->query($query);
$total_productos = 0;

if ($result && $row = $result->fetch_assoc()) {
    $total_productos = $row['total_productos'];
}

$query = "SELECT COUNT(*) AS total_usuarios FROM usuarios";
$result = $conn->query($query);
$total_usuarios = 0;

if ($result && $row = $result->fetch_assoc()) {
    $total_usuarios = $row['total_usuarios'];
}

$sql = "SELECT SUM(precio_salida) AS total_ingresos FROM detalle_salida";
$result = $conn->query($sql);
$totalIngresos = 0;

if ($result && $row = $result->fetch_assoc()) {
    $totalIngresos = $row['total_ingresos'];
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>ZOOVET</title>
	    <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="./public/css/bootstrap.min.css">
	    <!----css3---->
        <link rel="stylesheet" href="./public/css/custom.css">
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		
		
		<!--google fonts -->
	    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
		<!-- FullCalendar CSS y JavaScript -->
		<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

	
	   <!--google material icon-->
      <link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">

  </head>
  <body>
  


<div class="wrapper">
     
	  <div class="body-overlay"></div>
	 
	 <!-------sidebar--design------------>
	 
	 <div id="sidebar">
	    <div class="sidebar-header">
		   <h3><img src="./public/img/logo.jpg" class="img-fluid"/><span></span></h3>
		</div>
		<ul class="list-unstyled component m-0">
		  <li class="active">
		  <a href="./index.php" class="dashboard" id="panel-dashboard">
			<i class="material-icons">P</i>Panel</a>
		  </li>
		  
		  <li >
			<a href="#" class="button" id="panel-usuarios">
			<i class="material-icons">group</i>Usuarios
			</a>
		  </li>
		  <li >
			<a href="#" class="button" id="panel-propietarios">
			<i class="material-icons">group</i>Propietarios
			</a>
		  </li>
		  <li >
			<a href="#" class="button" id="panel-medicos">
			<i class="material-icons">group</i>Veterinarios
			</a>
		  </li>
		  <li >
			<a href="#" class="button" id="panel-mascotas">
			<i class="material-icons">pets</i>Mascotas
			</a>
		  </li>
		  
		   <li class="dropdown">
		  <a href="#homeSubmenu3" data-toggle="collapse" aria-expanded="false" 
		  class="dropdown-toggle">
		  <i class="material-icons">equalizer</i>Consultas
		  </a>
		  <ul class="collapse list-unstyled menu" id="homeSubmenu3">
		     <li><a href="#" class="button" id="panel-general">Consulta general</a></li>
			 <li><a href="#" class="button" id="panel-profilactico">Control profiláctico</a></li>
			 <li><a href="#" class="button" id="panel-cirugias">Cirugías</a></li>
		  </ul>
		  </li>
		  <li >
			<a href="#" class="button" id="panel-campañas">
			<i class="material-icons">campaign</i>Campañas
			</a>
		  </li>
		  <li >
			<a href="#" class="button" id="panel-citas">
			<i class="material-icons">extension</i>Citas
			</a>
		  </li>
		  
		  <li >
			<a href="#" class="button" id="panel-expedientes">
			<i class="material-icons">assignment</i>Expedientes
			</a>
		  </li>

		  <li >
			<a href="#" class="button" id="panel-productos">
			<i class="material-icons">workspaces</i>Productos
			</a>
		  </li>
		  
		  
		  <li >
			<a href="#" class="button" id="panel-compras">
			<i class="material-icons">grid_on</i>Compras
			</a>
		  </li>

		  <li >
			<a href="#" class="button" id="panel-salidas">
			<i class="material-icons">content_copy</i>Salidas
			</a>
		  </li>		   
		  <li class="">
		  <a href="#" class="button" id="panel-inventario"><i class="material-icons">date_range</i>Inventario </a>
		  </li>
		  <li class="">
		  <a href="#" class="button" id="panel-reportes"><i class="material-icons">library_books</i>Reportes </a>
		  </li>
		  <li class="">
		  <a href="#" class="button" id="panel-ayuda"><i class="material-icons">help</i>Ayuda </a>
		  </li>
		
		</ul>
	 </div>
	 
   <!-------sidebar--design- close----------->
   
   
   
      <!-------page-content start----------->
   
      <div id="content">
	     
		  <!------top-navbar-start BUSCADOR-----------> 
		     
		  <div class="top-navbar">
		     <div class="xd-topbar">
			     <div class="row">
				     <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
					    <div class="xp-menubar" >
						    <span class="material-icons text-white">signal_cellular_alt</span>
						</div>
					 </div>
					 
					 
					 <div class="col-11 col-md-11 col-lg-11 order-1 order-md-3">
					     <div class="xp-profilebar text-right">
						    <nav class="navbar p-0">
							   <ul class="nav navbar-nav flex-row ml-auto">
							   
							   
							   <li class="dropdown nav-item">
							     <a class="nav-link" href="#" data-toggle="dropdown">
								  <img src="./public/img/iconousuario.jpg" style="width:40px; border-radius:50%;"/>
								  <span class="xp-user-live"></span>
								 </a>
								  <ul class="dropdown-menu small-menu">
								     <li><a href="#" id="panel-perfil">
									 <span class="material-icons">person_outline</span>
									 Perfil
									 </a></li>									 
									 <li><a href="./views/logout.php" id="logoutButton">
									 <span class="material-icons">logout</span>
									 Salir
									 </a></li>
									 
								  </ul>
							   </li>
							   
							   
							   </ul>
							</nav>
						 </div>
					 </div>
					 
				 </div>
				 
				 <div class="xp-breadcrumbbar text-center">
				    <h4 class="page-title">SISTEMA DE GESTIÓN DE EXPEDIENTES E INVENTARIOS ZOOVET</h4>
				 </div>
				 
				 
			 </div>
		  </div>
		  <!------top-navbar-end-----------> 
		  
		  
		   <!------main-content-start-----------> 
		     
		      	<div class="main-content" id="sub-data">
			     <div class="row">
					    
					   <div class="col-md-4">
							<div class="card bg-primary text-white mb-4 shadow-sm hover-shadow cursor-pointer">
								<div class="card-body">Total de Mascotas</div>
								<div class="card-footer d-flex align-items-center justify-content-between">
									<h5 class="mb-0"><?php echo $total_mascotas; ?></h5>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<a href="#" style="text-decoration: none;">
							<div class="card bg-success text-white mb-4 shadow-sm hover-shadow cursor-pointer">
								<div class="card-body">Total Médicos</div>
								<div class="card-footer d-flex align-items-center justify-content-between">
									<h5 class="mb-0"><?php echo $total_medicos; ?></h5></div>
							</div></a>
						</div>
						<div class="col-md-4">
							<div class="card bg-info text-white mb-4 shadow-sm hover-shadow cursor-pointer">
								<div class="card-body">Total de Consultas</div>
								<div class="card-footer d-flex align-items-center justify-content-between">
									<h5 class="mb-0"><?php echo $total_consultas; ?></h5>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card bg-secondary text-white mb-4">
								<div class="card-body">Total de Productos</div>
								<div class="card-footer d-flex align-items-center justify-content-between">
									<h5 class="mb-0"><?php echo $total_productos; ?></h5>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card bg-warning text-white mb-4">
								<div class="card-body">Ingresos Totales</div>
								<div class="card-footer d-flex align-items-center justify-content-between">
									<h5 class="mb-0"><?php echo "$ " . number_format($totalIngresos, 2); ?></h5>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card bg-dark text-white mb-4">
								<div class="card-body">Total de Usuarios</div>
								<div class="card-footer d-flex align-items-center justify-content-between">
									<h5 class="mb-0"><?php echo $total_usuarios; ?></h5>
								</div>
							</div>
						</div>
						
						<div class="container col-md-6" style="position: relative; height:300px; width:100%; margin-bottom: 100px;">
    						<h2>Consultas por Mes</h2><br>
    						<canvas id="consultasMesChart" width="400" height="200"></canvas>
						</div>
						<div class="container col-md-6" style="position: relative; height:275px; width:100%;">
						<h2>Consultas por Tipo</h2>
						<select id="mesSelector">
							<option value="1">Enero</option>
							<option value="2">Febrero</option>
							<option value="3">Marzo</option>
							<option value="4">Abril</option>
							<option value="5">Mayo</option>
							<option value="6">Junio</option>
							<option value="7">Julio</option>
							<option value="8">Agosto</option>
							<option value="9">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>

							<option value="12">Diciembre</option>
						</select>
						<canvas id="consultasTipoChart" ></canvas>
						</div>

						<span class="input-group-text col-md-12" style="position: relative; margin-bottom: 40px;"><b>
							<h4>CALENDARIO CITAS</h4></b>
						</span>
						<div id="calendar" class="col-md-6" style="margin-bottom: 40px;"></div>
						
						<div class="col-md-10">
						<h2 style="position: relative; margin-bottom: 10px;">Detalle Consultas Recientes</h2>
						</div>
			<table class="table table-bordered mt-3">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nombre Mascota</th>
						<th>Fecha Consulta</th>
						<th>Veterinario</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT c.id_consulta, m.nombre_mascota, c.fecha_consulta,  
				CONCAT(d.nombre, ' ', d.apellido) AS nombre_completo
					FROM consultas AS c
					INNER JOIN mascota AS m ON c.id_mascota = m.id_mascota	
					INNER JOIN usuarios as d ON d.id_usuario = c.id_veterinario
					ORDER BY c.fecha_consulta DESC LIMIT 5";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "<tr>
									<td>{$row['id_consulta']}</td>
									<td>{$row['nombre_mascota']}</td>
									<td>{$row['fecha_consulta']}</td>
									<td>{$row['nombre_completo']}</td>
								</tr>";
						}
					} else {
						echo "<tr><td colspan='5'>No hay consultas recientes</td></tr>";
					}
					?>
				</tbody>
			</table>   
					
			     </div>
			  </div>
		  
		    <!------main-content-end-----------> 
		  
		 
		 
		 <!----footer-design------------->
		 
		 <footer class="footer">
		    <div class="container-fluid">
			   <div class="footer-in">
			      <p class="mb-0">&copy 2024 Consultorio Médico Veterinario ZOOVET</p>
			   </div>
			</div>
		 </footer>
		 
		 
		 
		 
	  </div>
   
</div>

   <script src="./public/js/jquery-3.3.1.slim.min.js"></script>
   <script src="./public/js/popper.min.js"></script>
   <script src="./public/js/bootstrap.min.js"></script>
   <script src="./public/js/jquery-3.3.1.min.js"></script>
  
  <script type="text/javascript">
       $(document).ready(function(){
	      $(".xp-menubar").on('click',function(){
		    $("#sidebar").toggleClass('active');
			$("#content").toggleClass('active');
		  });
		  
		  $('.xp-menubar,.body-overlay').on('click',function(){
		     $("#sidebar,.body-overlay").toggleClass('show-nav');
		  });
		  
	   });
  </script>
  
  <script>
	$(document).ready(function() {

            $("#panel-usuarios").click(function() {
                $("#sub-data").load("./views/usuarios/principal.php");
                return false;
            });

			$("#panel-propietarios").click(function() {
                $("#sub-data").load("./views/propietarios/principal.php");
                return false;
            });

			$("#panel-medicos").click(function() {
                $("#sub-data").load("./views/medicos/principal.php");
                return false;
            });

			$("#panel-mascotas").click(function() {
                $("#sub-data").load("./views/mascotas/principal.php");
                return false;
            });  
			$("#panel-citas").click(function() {
                $("#sub-data").load("./views/citas/principal.php");
                return false;
            }); 
			$("#panel-general").click(function() {
                $("#sub-data").load("./views/consultas/general/principal.php");
                return false;
            }); 
			$("#panel-profilactico").click(function() {
                $("#sub-data").load("./views/consultas/profilactico/principal.php");
                return false;
            }); 
			$("#panel-cirugias").click(function() {
                $("#sub-data").load("./views/consultas/cirugias/principal.php");
                return false;
            }); 
			$("#panel-perfil").click(function() {
                $("#sub-data").load("./views/perfil.php");
                return false;
            }); 
			$("#panel-compras").click(function() {
                $("#sub-data").load("./views/compras/principal.php");
                return false;
            }); 
			$("#panel-productos").click(function() {
                $("#sub-data").load("./views/productos/principal.php");
                return false;

            });
			$("#panel-salidas").click(function() {
                $("#sub-data").load("./views/salidas/principal.php");
                return false;
            });  
			$("#panel-inventario").click(function() {
                $("#sub-data").load("./views/inventario/principal.php");
                return false;
            });  
			$("#panel-reportes").click(function() {
                $("#sub-data").load("./views/reportes/principal.php");
                return false;
            });  

            }); 
			$("#panel-expedientes").click(function() {
                $("#sub-data").load("./views/expedientes/principal.php");
                return false;
            });
			$("#panel-ayuda").click(function() {
                $("#sub-data").load("./views/ayuda/principal.php");
                return false;
            });
			$("#panel-campañas").click(function() {
                $("#sub-data").load("./views/campañas/principal.php");
                return false;
            });

        
  </script>

<script>
        $(document).ready(function() {
            $('#logoutButton').click(function(event) {
                event.preventDefault(); // Evita cualquier acción por defecto

                Swal.fire({
                    title: '¿Desea cerrar sesión?',
                    text: "¡Se cerrará tu sesión actual!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './views/logout.php'; // ruta
                    } else {
                        Swal.fire(
                            'Cancelado',
                            'Tu sesión permanece activa',
                            'info'
                        );
                    }
                });
            });
        });

//Obtener datos para gráfico Consultas
document.addEventListener("DOMContentLoaded", function() {
    fetch('views/consultasmes.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la red: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data); // Aquí debería mostrarse la respuesta

            // Solo para verificar el flujo
            if (data.length === 0) {
                console.warn('No se recibieron datos válidos.');
                return;
            }

            const labels = data.map(item => item.mes);
            const consultas = data.map(item => parseInt(item.total_consultas, 10)); // Convertir a número

            console.log('Etiquetas:', labels); // Debe mostrar etiquetas
            console.log('Consultas:', consultas); // Debe mostrar consultas

            // Crear el gráfico
            const ctx = document.getElementById('consultasMesChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Consultas por Mes',
                        data: consultas,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
					maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error al cargar los datos:', error); // Verifica si hay errores aquí
        });
});

//Obtener datos tipo consulta

document.addEventListener("DOMContentLoaded", function() {
    const mesSelector = document.getElementById('mesSelector');
    const ctx = document.getElementById('consultasTipoChart').getContext('2d');
    let chart; // Inicializa la variable para el gráfico

    function loadChart(mesSeleccionado) {
        fetch('views/tipoconsulta.php?mes=' + mesSeleccionado)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);

                const labels = data.map(item => item.tipo_consulta);
                const consultas = data.map(item => parseInt(item.total_consultas, 10));

                // Verifica si el gráfico ya existe y lo destruye
                if (chart) {
                    chart.destroy(); // Destruye el gráfico anterior
                }

                // Crea un nuevo gráfico de pastel
                chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Consultas por Tipo',
                            data: consultas,
                            backgroundColor: [
                                'rgb(26, 193, 62)',
                                'rgb(73, 211, 252)',
                                'rgb(172, 186, 251)',
                                // Agrega más colores si tienes más tipos
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(73, 211, 252, 1)',
                                'rgba(172, 186, 251, 2)',
                                // Agrega más colores si tienes más tipos
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
						maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw; // Muestra el total en la tooltip
                                    }
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error al cargar los datos:', error);
            });
    }

    // Cargar el gráfico inicial para el primer mes
    loadChart(mesSelector.value);

    // Agregar evento de cambio para el selector de meses
    mesSelector.addEventListener('change', function() {
        loadChart(this.value);
    });
});
    </script>

	<!--obtener citas-->
	<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        events: 'views/obtener_citas.php', // Ruta del archivo PHP que devuelve las citas en JSON
        eventClick: function(info) {
            alert('Cita: ' + info.event.title);
        }
    });

    calendar.render();
});

//Buscar 
document.addEventListener("DOMContentLoaded", function () {
    const currentView = document.getElementById("currentView");
    const subDataContainer = document.getElementById("sub-data");

    if (subDataContainer) {
        // Crear un observador para detectar cambios en las clases del contenedor
        const observer = new MutationObserver(function(mutationsList) {
            mutationsList.forEach((mutation) => {
                if (mutation.type === "attributes" && mutation.attributeName === "class") {
                    actualizarVistaActual();
                }
            });
        });

        // Observa cambios en los atributos del contenedor
        observer.observe(subDataContainer, { attributes: true });

        function actualizarVistaActual() {
            // Verificar y asignar la vista actual basada en clases
            if (subDataContainer.classList.contains("DataPanelUsuarios")) {
                currentView.value = "usuarios";
            } else if (subDataContainer.classList.contains("DataPanelExpedientes")) {
                currentView.value = "expedientes";
            } else if (subDataContainer.classList.contains("DataPanelProductos")) {
                currentView.value = "productos";
            } else if (subDataContainer.classList.contains("DataPanelPropietarios")) {
                currentView.value = "propietarios";
            } else if (subDataContainer.classList.contains("DataPanelMedicos")) {
                currentView.value = "medicos";
            } else if (subDataContainer.classList.contains("DataPanelMascotas")) {
                currentView.value = "mascotas";
            }
            console.log("Vista actualizada a:", currentView.value);
        }

        // Llamar la función al cargar para configurar la vista inicialmente
        actualizarVistaActual();
    }
});

</script>


  </body>
  
  </html>


