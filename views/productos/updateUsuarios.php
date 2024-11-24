<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idusuario = $_POST['idusuario'];
$usuario = $_POST['usuario'];
$num = $_POST['num'];
$num_reg = $_POST['num_reg'];
$tipo = $_POST['tipo'];

if (strlen($_POST['clave']) != 0) {
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
    $campos = "usuario='$usuario',clave='$clave',tipo='$tipo'";
} else {
    $campos = "usuario='$usuario',tipo='$tipo'";
}
$val_cond = "idusuario='$idusuario'";
$update = CRUD('usuarios', $campos, $val_cond, '', '', 'U');
?>
<script>
    $(document).ready(function() {
        let num = '<?php echo $num; ?>';
        let num_reg = '<?php echo $num_reg; ?>';
        let msj;
        <?php if ($update): ?>
            msj = 'Usuario actualizado';
        <?php else: ?>
            msj = 'Usuario no actualizado';
        <?php endif; ?>

        $.ajax({
                url: './views/usuarios/usuarios.php',
                type: 'post',
                data: {
                    num: num,
                    num_reg: num_reg,
                    msj: msj
                },
                success: function(response) {
                    $("#DataPanelUsuariosRoles").html(response);
                }
            });
        return false;
    });
</script>