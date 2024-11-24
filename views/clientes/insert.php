<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$usuario = $_POST['usuario'];
$clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
$tipo = $_POST['tipo'];
$estado = 1;
$campos = "usuario,clave,tipo,estado";
$val_cond = "'$usuario','$clave','$tipo','$estado'";
$insert = CRUD("usuarios", $campos,$val_cond,"usuario", $usuario, "I");
?>
<script>
    $(document).ready(function() {
        let msj;
        <?php if ($insert == 1): ?>
            msj = 'Usuario registrado';
        <?php elseif ($insert == 3): ?>
            msj = 'Usuario ya registrado';
        <?php else: ?>
            msj = 'Error, usuario no registrado';
        <?php endif; ?>
       
            $.ajax({
                url: './views/usuarios/usuarios.php',
                type: 'post',
                data: {
                    msj: msj
                },
                success: function(response) {
                    $("#DataPanelUsuariosRoles").html(response);
                }
            });
        return false;
    });
</script>