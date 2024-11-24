<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$categoria = $_POST['categoria'];
$estado = 1;
$campos = "categoria,estado";
$val_cond = "'$categoria','$estado'";
$insert = CRUD("categorias", $campos, $val_cond,"categoria", $categoria, "I");
?>
<script>
    $(document).ready(function() {
        let msj;
        <?php if ($insert == 1): ?>
            msj = 'Categoría registrado';
        <?php elseif ($insert == 3): ?>
            msj = 'Categoría ya registrado';
        <?php else: ?>
            msj = 'Error, categoría no registrado';
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