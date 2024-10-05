<div class="wrapper">
     
	  <div class="body-overlay"></div>
	 
	 <!-------sidebar--design------------>
	 
	 <div id="sidebar">
	    <div class="sidebar-header">
		   <h3><img src="./public/img/logo.jpg" class="img-fluid"/><span>ZOOVET</span></h3>
		</div>
		<ul class="list-unstyled component m-0">
		  <li class="active">
		  <a href="#" class="dashboard"><i class="material-icons">P</i>anel </a>
		  </li>
		  
		  <li >
			<a href="#" class="btn button3" id="Panel-Usuarios">
			<i class="material-icons">group</i>Usuarios
			</a>
		  </li>
		  <li class="dropdown">
		  <a href="#homeSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
		  <i class="material-icons">pets</i>Mascotas
		  </a>
		  
		  </li>
		  
		   <li class="dropdown">
		  <a href="#homeSubmenu3" data-toggle="collapse" aria-expanded="false" 
		  class="dropdown-toggle">
		  <i class="material-icons">equalizer</i>Consultas
		  </a>
		  <ul class="collapse list-unstyled menu" id="homeSubmenu3">
		     <li><a href="#">Consulta general</a></li>
			 <li><a href="#">Control profiláctico</a></li>
			 <li><a href="#">Cirugías</a></li>
		  </ul>
		  </li>
		  
		  
		   <li class="dropdown">
		  <a href="#homeSubmenu4" data-toggle="collapse" aria-expanded="false" 
		  class="dropdown-toggle">
		  <i class="material-icons">extension</i>Citas
		  </a>
		  </li>
		  
		   <li class="dropdown">
		  <a href="#homeSubmenu5" data-toggle="collapse" aria-expanded="false" 
		  class="dropdown-toggle">
		  <i class="material-icons">border_color</i>Expedientes
		  </a>
		  <ul class="collapse list-unstyled menu" id="homeSubmenu5">
		     
		  </ul>
		  </li>
		  
		  <li class="dropdown">
		  <a href="#homeSubmenu6" data-toggle="collapse" aria-expanded="false" 
		  class="dropdown-toggle">
		  <i class="material-icons">grid_on</i>Compras
		  </a>
		  <ul class="collapse list-unstyled menu" id="homeSubmenu6">
		     
		  </ul>
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
                                 placeholder="Search">
                                 <div class="input-group-append">
                                    <button class="btn" type="submit" id="button-addon2">Go
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
                                    <li><a href="#">
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

            
        });
  </script>


