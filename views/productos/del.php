<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idproducto = $_POST['idproducto'];
$pagina = $_POST['num'];
$registros = $_POST['num_reg'];
$val_cond = "idproducto='$idproducto'";
$del = CRUD("productos", "", $val_cond, '', '', "D");

?>

<script>
    $(document).ready(function() {
        let msj;
        let num, reg;
        num = '<?php echo $pagina; ?>';
        reg = '<?php echo $registros; ?>';
        <?php if ($del == 1): ?>
            msj = 'Producto eliminado';
        <?php else: ?>
            msj = 'Error, producto no eliminado';
        <?php endif; ?>

        $.ajax({
            url: './views/productos/principal.php',
            type: 'post',
            data: {
                msj: msj,
                num: num,
                num_reg: reg
            },
            success: function(response) {
                $("#data").html(response);
            }
        });
        return false;
    });
</script>