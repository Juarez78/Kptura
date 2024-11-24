<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idusuario = $_POST['idusuario'];
$valor = $_POST['valor'];
$num = $_POST['num'];
$num_reg = $_POST['num_reg'];
$val_cond = "estado='$valor'";
$condicion = "idusuario='$idusuario'";
$accion = CRUD('usuarios', $val_cond, $condicion, '', '', 'U');

?>
<script>
    $(document).ready(function() {
        let num = <?php echo $num; ?>;
        let reg = '<?php echo $num_reg; ?>';

        <?php if ($accion): ?>
            alertify.success('Estado actualizado');
        <?php else: ?>
            alertify.error('Error estado no actualizado');
        <?php endif; ?>
        $.ajax({
            url: './views/usuarios/usuarios.php',
            type: 'post',
            data: {
                num: num,
                num_reg: reg
            },
            success: function(response) {
                $("#DataPanelUsuariosRoles").html(response);
            }
        });
    });
</script>