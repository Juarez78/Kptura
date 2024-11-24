<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idcategoria = $_POST['idcategoria'];
$val_cond = "idcategoria='$idcategoria'";
$del = CRUD("categorias", "",$val_cond,"","", "D");
?>
<script>
    $(document).ready(function() {
        let msj;
        <?php if ($del== 1): ?>
            msj = 'Categoría eliminada';
        <?php else: ?>
            msj = 'Error, categoría no eliminada';
        <?php endif; ?>
            $.ajax({
                url: './views/categorias/principal.php',
                type: 'post',
                data: {
                    msj: msj
                },
                success: function(response) {
                    $("#data").html(response);
                }
            });
        return false;
    });
</script>