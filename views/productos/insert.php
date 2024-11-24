<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idproducto = $_POST['idproducto'];
$producto = $_POST['producto'];
$detalle = $_POST['detalle'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$idcategoria = $_POST['idcategoria'];
$idproveedor = $_POST['idproveedor'];
$imagen = $_FILES['imagen'];
$rutaDestino = '../../public/img/productos/';
$tipoArchivo = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
$file = $idproducto.'.'.$tipoArchivo;

// Solo una llamada a subirImagen
$val_img = subirImagen($imagen, $rutaDestino, $idproducto);

if($val_img == 1) {
    $campos = "idproducto,imagen,nombre,detalle,precio,stock,idcategoria,idproveedor";
    $val_cond = "'$idproducto','$file','$producto','$detalle','$precio','$stock','$idcategoria','$idproveedor'";
    $insert = CRUD("productos", $campos, $val_cond, "nombre", $producto, "I");
} else {
    $insert = 0; // Retorna el valor de error de la función
}
?>

<script>
    $(document).ready(function() {
        let msj;
        <?php if ($insert == 1): ?>
            msj = 'Producto registrado';
        <?php elseif ($insert == 2): ?>
            msj = "El archivo no es una imagen válida.";
        <?php elseif ($insert == 3): ?>
            msj = 'Producto ya registrado';
        <?php elseif ($insert == 4): ?>
            msj = "Solo se permiten archivos con las extensiones: png, jpg, jpeg.";
        <?php else: ?>
            msj = 'Error, producto no registrado';
        <?php endif; ?>
       
        $.ajax({
            url: './views/productos/principal.php',
            type: 'post',
            data: { msj: msj },
            success: function(response) {
                $("#data").html(response);
            }
        });
        return false;
    });
</script>
