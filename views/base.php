<?php
@session_start();

if (isset($_POST['off'])) {
    $_SESSION = [];
    session_destroy();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="./public/img/logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (isset($_SESSION['LoginAccess'])) : ?>
        <title>ZOOVET</title>
    <?php else : ?>
        <title>Login</title>
    <?php endif ?>
    <!-- Bootstrap 5.0.2 CSS local -->
    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/css/botonsalir.css">
    <!-- jQuery -->
    <script src="./public/js/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5.0.2 JS bundle local -->
    <script src="./public/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body id="dataRoot">
    <?php if (isset($_SESSION['LoginAccess'])) : ?>
    <?php endif ?>

    <div class="container-fluid" id="data">
        <?php if (isset($_SESSION['LoginAccess'])) : ?>
            <?php include './views/principal.php'; ?>
        <?php else : ?>
            <?php include './views/login.php'; ?>
        <?php endif ?>
    </div>
    <?php
        include './views/modal.php';
        include './views/modal_productos.php';
    ?>
</body>

</html>
