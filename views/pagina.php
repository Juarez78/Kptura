<?php
include './models/conexion.php';
include './models/funciones.php';
include './controllers/funciones.php';

$dataProductos = CRUD('productos', '*', '', '', '', 'S');
?>

<a class="btn" id="acceso-login" style="background-color: #39774e; color: white; margin-top: 5px; float: right; overflow: auto;">
    <i class="fa-solid fa-right-to-bracket"></i>
</a>
<div class="centrar">
    <p><b>Store SV</b></p>
</div>
<br>
<hr>
<div class="row">
    <?php foreach ($dataProductos as $result): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <p><b><?php echo $result['nombre']; ?></b></p>
                    <img src="./public/img/productos/<?php echo $result['imagen']; ?> ?>" class="img-fluid" alt="">
                </div>
                <div class="card-footer">
                    <b>Para mas detalles registrate o inicia sesión</b>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<script>
    $(document).ready(function() {
        $("#acceso-login").click(function() {
            $("#principal").load("./views/login.php");
            return false;
        });
    });
</script>