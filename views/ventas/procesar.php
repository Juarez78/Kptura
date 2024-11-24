<?php
session_start();
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idusuario = $_SESSION['idusuario'];
$tipo = $_SESSION['tipo'];
$idcarrito = $_POST['idcarrito'];

for ($i = 0; count($idcarrito) >= $i; $i++) {
    if ($tipo == 1 || $tipo == 2) {
        $insert = CRUD("ticket", "idcarrito,estado,fecha", "'" . $idcarrito[$i] . "',1,NOW()", "", "", "ISB");
    } else {
        $update = CRUD("carrito", "estado=2", "idcarrito='" . $idcarrito[$i] . "'", "", "", "U");
    }
}

$idcarritos = implode(", ", $idcarrito);

if ($tipo == 1 || $tipo == 2 and $update) {
    $insert = CRUD("ticket", "idusuario,idcarrito,estado,fecha", "'" . $idusuario . "','" . $idcarritos . "',1,NOW()", "", "", "ISB");
} else {
    $insert = CRUD("ticket", "idusuario,idcarrito,estado,fecha", "'" . $idusuario . "','" . $idcarritos . "',2,NOW()", "", "", "ISB");
}
?>
<script>
    $(document).ready(function() {
        let msj;
        <?php if ($update == 1): ?>
            let tipo = "<?php echo $tipo; ?>";
            if (tipo == 1 || tipo == 2) {
                msj = 'Venta registrada....';
            } else {
                msj = 'Pedido registrado....';
            }
        <?php else: ?>
            if (tipo == 1 || tipo == 2) {
                msj = 'Error, al procesar venta';
            } else {
                msj = 'Error, al procesar pedido';
            }

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