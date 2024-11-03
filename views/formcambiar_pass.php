<!DOCTYPE html>
<html lang="es">

    
   


<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../public/img/logo.jpg">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.css"/>
        <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <title>Restablecer Contraseña</title>
        <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #095169;
        }
        .container {
            background-color: #fff;
            padding: 60px;
            border-radius: 10px;
            box-shadow: 0 12px 24px rgba(9,81,105);
            width: 400px;
            text-align: center;
        }
        .container h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }
        .container label {
            display: block;
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
            text-align: left;
        }
        .container input[type="password"],
        .container input[type="email"] {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 25px;
            font-size: 16px;
        }
        .container button {
            width: 100%;
            padding: 15px;
            background-color: #095169;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #29587d;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Restablecer Contraseña</h2>
        <form action="./resset_pass.php" method="POST"> <!-- Cambia a la ruta de tu script -->
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>"> <!-- Agrega el token al formulario -->
            <label for="new_password">Nueva Contraseña</label>
            <input type="password" id="new_password" name="new_password" placeholder="Nueva contraseña" required>
            <label for="confirm_password">Confirmar Contraseña</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar contraseña" required>
            <button type="submit">Actualizar Contraseña</button>
        </form>
    </div>

</body>
</html>
