<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idcategoria = $_POST['idcategoria'];
$categoria = $_POST['categoria'];
$estado = $_POST['estado'];
$num = $_POST['num'];
$num_reg = $_POST['num_reg'];

$campos = "categoria='$categoria',estado='$estado'";

$val_cond = "idcategoria='$idcategoria'";
$update = CRUD('categorias', $campos, $val_cond, '', '', 'U');
?>
<script>
    $(document).ready(function() {
        let num = '<?php echo $num; ?>';
        let num_reg = '<?php echo $num_reg; ?>';
        let msj;
        <?php if ($update): ?>
            msj = 'Categoría actualizada';
        <?php else: ?>
            msj = 'Categoría no actualizado';
        <?php endif; ?>

        $.ajax({
                url: './views/categorias/principal.php',
                type: 'post',
                data: {
                    num: num,
                    num_reg: num_reg,
                    msj: msj
                },
                success: function(response) {
                    $("#data").html(response);
                }
            });
        return false;
    });
</script>