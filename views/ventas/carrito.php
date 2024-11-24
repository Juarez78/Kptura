<?php
session_start();
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idusuario = $_SESSION['idusuario'];
$tipo = $_SESSION['tipo'];
$idproducto = $_POST['idproducto'];
$cantidad = $_POST['cantidad'];
$precio = buscavalor('productos', 'precio', 'idproducto="' . $idproducto . '"');
$newstock = buscavalor('productos', 'stock', 'idproducto="' . $idproducto . '"') - $cantidad;
$total = ($precio * $cantidad);

$campos = "idusuario,idproducto,cantidad,total,estado";
$val_cond = "'$idusuario','$idproducto','$cantidad','$total',0";
$insert = CRUD("carrito", $campos, $val_cond, '', '', "ISB");
?>
<script>
    $(document).ready(function() {
        let msj;
        <?php if ($insert == 1): ?>
            <?php
            $campos = "stock='$newstock'";
            $val_cond = "idproducto='$idproducto'";
            CRUD("productos", $campos, $val_cond, '', '', "U");
            ?>
            msj = 'Producto agregado a carrito';
        <?php else: ?>
            msj = 'Error, al agregrar producto a carrito';
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