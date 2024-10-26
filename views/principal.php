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
		
		
		<!--google fonts -->
	    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
	
	
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
		  <a href="#" class="dashboard"><i class="material-icons">P</i>Panel </a>
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
			<a href="#" class="button" id="panel-citas">
			<i class="material-icons">extension</i>Citas
			</a>
		  </li>
		  
		  <li >
			<a href="#" class="button" id="panel-expedientes">
			<i class="material-icons">extension</i>Expedientes
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
		  
		  
		  <li class="dropdown">
		  <a href="#homeSubmenu7" data-toggle="collapse" aria-expanded="false" 
		  class="dropdown-toggle">
		  <i class="material-icons">content_copy</i>Salidas
		  </a>
		  <ul class="collapse list-unstyled menu" id="homeSubmenu7">
		     <li><a href="#">Pages 1</a></li>
			 <li><a href="#">Pages 2</a></li>
			 <li><a href="#">Pages 3</a></li>
		  </ul>
		  </li>
		  
		   
		  <li class="">
		  <a href="#" class=""><i class="material-icons">date_range</i>Inventario </a>
		  </li>
		  <li class="">
		  <a href="#" class=""><i class="material-icons">library_books</i>Reportes </a>
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
					    <div class="xp-menubar">
						    <span class="material-icons text-white">signal_cellular_alt</span>
						</div>
					 </div>
					 
					 <div class="col-md-5 col-lg-3 order-3 order-md-2">
					     <div class="xp-searchbar">
						     <form>
							    <div class="input-group">
								  <input type="search" class="form-control"
								  placeholder="Búsqueda">
								  <div class="input-group-append">
								     <button class="btn" type="submit" id="button-addon2">Ir
									 </button>
								  </div>
								</div>
							 </form>
						 </div>
					 </div>
					 
					 
					 <div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
					     <div class="xp-profilebar text-right">
						    <nav class="navbar p-0">
							   <ul class="nav navbar-nav flex-row ml-auto">
							   
							   
							   <li class="dropdown nav-item">
							     <a class="nav-link" href="#" data-toggle="dropdown">
								  <img src="./public/img/user.jpg" style="width:40px; border-radius:50%;"/>
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
				    <h4 class="page-title">ZOOVET</h4>
					<ol class="breadcrumb">
					  <li class="breadcrumb-item"><a href="#">Principal</a></li>
					  <li class="breadcrumb-item active" aria-curent="page">Dashboard</li>
					</ol>
				 </div>
				 
				 
			 </div>
		  </div>
		  <!------top-navbar-end-----------> 
		  
		  
		   <!------main-content-start-----------> 
		     
		      <div class="main-content" id="sub-data">
			     <div class="row">
				    <div class="col-md-12">
					   <div class="table-wrapper">
					     
					   <div class="table-title">
					     <div class="row">
						     <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
							    <h2 class="ml-lg-2">Controles</h2>
							 </div>
							 
					     </div>
					   </div>
					   
					   <table class="table table-striped table-hover">
					      <thead>
						     <tr>
							 <th><span class="custom-checkbox">
							 <input type="checkbox" id="selectAll">
							 <label for="selectAll"></label></th>
							 <th>Campo 1</th>
							 <th>Campo 2</th>
							 <th>Campo 3</th>
							 <th>Campo 4</th>
							 <th>Acciones</th>
							 </tr>
						  </thead>
						  
						  
						  
					      
					   </table>
					   
					   <div class="clearfix">
					     <div class="hint-text">showing <b>5</b> out of <b>25</b></div>
					     <ul class="pagination">
						    <li class="page-item disabled"><a href="#">Previous</a></li>
							<li class="page-item "><a href="#"class="page-link">1</a></li>
							<li class="page-item "><a href="#"class="page-link">2</a></li>
							<li class="page-item active"><a href="#"class="page-link">3</a></li>
							<li class="page-item "><a href="#"class="page-link">4</a></li>
							<li class="page-item "><a href="#"class="page-link">5</a></li>
							<li class="page-item "><a href="#" class="page-link">Next</a></li>
						 </ul>
					   </div>
				 
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



<!-------complete html----------->





  
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   <!--<script src="pujs/jquery-3.3.1.slim.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/jquery-3.3.1.min.js"></script>-->
  
   <!--<script src="pujs/jquery-3.3.1.slim.min.js"></script>-->
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
			$("#panel-expedientes").click(function() {
                $("#sub-data").load("./views/expedientes/principal.php");
                return false;
            });
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
    </script>

  </body>
  
  </html>


