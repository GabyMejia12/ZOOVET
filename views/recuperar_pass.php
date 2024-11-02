
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../public/img/logo.jpg">
    <title>Recuperar Contraseña</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }
        .container img {
            width: 70px;
            margin-bottom: 30px;
        }
        .container h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }
        .container p {
            font-size: 16px;
            color: #333;
            margin-bottom: 30px;
        }
        .container label {
            display: block;
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
            text-align: left;
        }
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
        .container a {
            display: block;
            font-size: 14px;
            color: #666;
            margin-top: 20px;
            text-decoration: none;
        }
        .container a:hover {
            color: #333;
        }
    </style>
</head>
<body>

    <div class="container">
    <i class="material-icons" style="font-size: 70px; color: #376995;">help</i>

        <h2>¿Olvidaste tu contraseña?</h2>
        <p>No te preocupes, es posible recuperarla.</p>
        <form action="./update_pass.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="tu-email@ejemplo.com" required>
            <button type="submit">Recuperar Contraseña</button>
        </form>
        <a href="../index.php">La he recordado</a>
    </div>

</body>
</html>
