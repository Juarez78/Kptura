<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';
$pagina = $_POST['num'];
$registros = $_POST['num_reg'];
$idproducto = $_POST['idproducto'];
$producto = $_POST['producto'];
$detalle = $_POST['detalle'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$idcategoria = $_POST['idcategoria'];
$idproveedor = $_POST['idproveedor'];
$old_img = $_POST['old_img'];
$imagen = $_FILES['imagen'];
$rutaDestino = '../../public/img/productos/';
$tipoArchivo = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
$file = $idproducto . '.' . $tipoArchivo;

if ($imagen['size'] != 0) {
    chmod($rutaDestino . $old_img, 0777);
    unlink($rutaDestino . $old_img);

    $val_img = subirImagen($imagen, $rutaDestino, $idproducto);

    if ($val_img == 1) {
        $campos = "imagen='$file',nombre='$producto',detalle='$detalle',precio='$precio',stock='$stock',idcategoria='$idcategoria',idproveedor='$idproveedor'";
        $val_cond = "idproducto='$idproducto'";
        $update = CRUD("productos", $campos, $val_cond, "", "", "U");
    } else {
        $update = 5;
    }
} else {
    $campos = "nombre='$producto',detalle='$detalle',precio='$precio',stock='$stock',idcategoria='$idcategoria',idproveedor='$idproveedor'";
    $val_cond = "idproducto='$idproducto'";
    $update = CRUD("productos", $campos, $val_cond, "", "", "U");
}
?>

<script>
    $(document).ready(function() {
        let msj;
        let num, reg;
        num = '<?php echo $pagina; ?>';
        reg = '<?php echo $registros; ?>';
        <?php if ($update == 1): ?>
            msj = 'Producto actualizado';
        <?php elseif ($update == 2): ?>
            msj = "El archivo no es una imagen válida.";
        <?php elseif ($update == 4): ?>
            msj = "Solo se permiten archivos con las extensiones: png, jpg, jpeg.";
        <?php elseif ($update == 5): ?>
            msj = "Error al cargar imagen...";
        <?php else: ?>
            msj = 'Error, producto no actualizado';
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
    });
</script>