<?php
session_start();
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idusuario = $_SESSION['idusuario'];
$tipo = $_SESSION['tipo'];
$idcarrito = $_POST['idcarrito'];
$idproducto = $_POST['idproducto'];
$cantidad = $_POST['cantidad'];
$newstock = buscavalor('productos', 'stock', 'idproducto="' . $idproducto . '"') + $cantidad;

$campos = "idusuario,idproducto,cantidad,total,estado";
$val_cond = "idcarrito='" . $idcarrito . "'";
$del = CRUD("carrito", "", $val_cond, "", "", "D")
?>
<script>
    $(document).ready(function() {
        let msj;
        <?php if ($del == 1): ?>
            <?php
            $campos = "stock='$newstock'";
            $val_cond = "idproducto='$idproducto'";
            CRUD("productos", $campos, $val_cond, '', '', "U");
            ?>
            msj = 'Producto eliminado de carrito';
        <?php else: ?>
            msj = 'Error, al eliminar producto del carrito';
        <?php endif; ?>

        $.ajax({
            url: './views/ventas/preventa.php',
            type: 'post',
            data: {
                msj: msj
            },
            success: function(response) {
                $("#Data-Ventas").html(response);
            }
        });
        //return false;
    });
</script>