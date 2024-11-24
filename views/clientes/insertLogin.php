<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$dui = $_POST['dui'];
$idusuario = MaxID('usuarios', 'idusuario') + 1;


$campos0 = "nombre,apellido,telefono,correo,direccion,dui,idusuario";
$val_cond0 = "'$nombre','$apellido','$telefono','$correo','$direccion','$dui','$idusuario'";
$insert0 = CRUD("clientes", $campos0, $val_cond0, "dui", "$dui", "I");

$usuario = $_POST['usuario'];
$clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
$tipo = 3;
$estado = 1;
$campos = "idusuario,usuario,clave,tipo,estado";
$val_cond = "'$idusuario','$usuario','$clave','$tipo','$estado'";
$insert = CRUD("usuarios", $campos, $val_cond, "usuario", $usuario, "I");

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
            url: './views/login.php',
            type: 'post',
            data: {
                msj: msj
            },
            success: function(response) {
                $("#principal").html(response);
            }
        });
        return false;
    });
</script>