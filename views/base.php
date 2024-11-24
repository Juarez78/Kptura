<?php
if (isset($_POST['off']) || isset($_GET['off'])) {
    session_start();
    $_SESSION = array();
    session_destroy();
    unset($_SESSION['login_ok']);
    echo '<script>
                window.location.replace("index.php");
            </script>';
} else {
    @session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if (isset($_SESSION['login_ok'])): ?>
        <title>Store</title>
    <?php else: ?>
        <title>Store SV</title>
    <?php endif ?>

    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/css/estilo.css">
    <link rel="stylesheet" href="./public/css/alertify.min.css">
    <link rel="stylesheet" href="./public/css/default.min.css">

    <script src="./public/js/jquery-3.7.1.slim.min.js"></script>
    <script src="./public/js/jquery-1.9.1.js"></script>
    <script src="./public/js/bootstrap.min.js"></script>
    <script src="./public/js/fontaweson.js"></script>
    <script src="./public/js/alertify.min.js"></script>
    <script src="./public/js/funciones.js"></script>

    <!-- Inputmask -->
    <script src="./public/js/inputmask.js"></script>
    <script src="./public/js/jquery.inputmask.bundle.js"></script>
    <link href="./public/css/inputmask.min.css" rel="stylesheet" />
</head>
<body id="toor">
    <div id="principal" class="container-fluid">
        <?php
        if (isset($_SESSION['login_ok'])) {
            include './views/principal.php';
            include './views/modals/modulos.php';
        }else{
            include './views/pagina.php';
        }
        ?>
    </div>
</body>
</html>