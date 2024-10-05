<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="./public/css/login.css">
    <style type="text/css">

    </style>

    <script type="text/javascript">

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div id="contenedor">            
            <div id="contenedorcentrado">
            <div id="derecho">
                    <div class="titulo">
                        Bienvenido/a
                    </div>
                    <hr>
                    <div class="pie-form">
                        <div class="centrar-imagen">
                            <img src="./public/img/logozoovet.png"width="200" height="200">
                        </div>
                        
                    </div>
                </div>
                <div id="login">
                    <form id="loginform" action="./controllers/controllersLogin.php" method="post">
                        
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-user-group"> Usuario</i>
                                </span>
                                <input type="text" class="form-control" placeholder="Ingrese Usuario" name="usuario" required autocomplete="off">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-key"> Clave</i>
                                </span>
                                <input type="password" class="form-control" placeholder="Ingrese Contraseña" name="password" required autocomplete="off">
                            </div>
                            <button class="btn btn-primary" name="BtnLogin"><b>Ingresar</b></button>
                        
                    </form>
                                     
                </div>
                
            </div>
    </div>
</body>
