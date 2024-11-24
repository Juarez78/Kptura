<?php
include './models/conexion.php';
include './models/funciones.php';
include './controllers/funciones.php';
?>
<div class="row" style="margin-top:5px;margin-bottom: 10px;">
    <div class="col-md-12 auto-md">
        <div class="card">
            <div class="card-header colorNavbar">
                <a href="./index.php" class="btn btnNavbar"><i class="fa-solid fa-house-laptop"></i></a>
                <?php if ($_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2): ?>
                    <a href="" class="btn btnNavbar" id="modulos"><i class="fa-solid fa-rectangle-list"></i></a>
                <?php else: ?>
                    <a href="" class="btn btnNavbar Panel-Ticket"><i class="fa-solid fa-clipboard-list"></i></a>
                <?php endif ?>
                <a href="" class="btn btnNavbar"><i class="fa-solid fa-id-badge"></i></a>
                <a href="" class="btn btn-danger btn-sm" style="float:right" id="exit">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>
            <div class="card-body" id="data">
                <div class="centrar" style="margin-bottom: 20px;">
                    <b style="float: right;">Bienvenido: <?php echo buscavalor('usuarios', 'usuario', 'idusuario="' . $_SESSION['idusuario'] . '"'); ?></b><br>
                    <img src="./public/img/logo.png" width="150px" alt="">
                </div>
                <?php
                @session_start();
                if ($_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2) {
                    if ($_SESSION['tipo'] == 1) {
                        echo "<h3 class='centrar'><b>Panel Administrador</b></h3><hr>";
                    } else {
                        echo "<h3 class='centrar'><b>Panel Empleados</b></h3><hr>";
                    }
                    include './views/administracion.php';
                } else {
                    include './views/clientes.php';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        /* Modulo Ticket */
        $("#Panel-Ticket,.Panel-Ticket").click(function() {
            $("#data").load("./views/tickets/principal.php");
            $("#ModalModulos").modal("hide");
            return false;
        });
    });
</script>