<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idproducto = $_GET['idproducto'];
$num = $_GET['num'];
$num_reg = $_GET['num_reg'];
$condicion = "idproducto='$idproducto'";
$dataUsuario = CRUD('productos', '*', 'idproducto="' . $idproducto . '"', '', '', 'SC');
foreach ($dataUsuario as $result) {
    $producto = $result['nombre'];
    $detalle = $result['detalle'];
    $precio = $result['precio'];
    $stock = $result['stock'];
    $idcategoria = $result['idcategoria'];
    $idproveedor = $result['idproveedor'];
    $imagen = $result['imagen'];
}
$proveedor = buscavalor('proveedores', 'proveedor', 'idproveedor="' . $idproveedor . '"');
$condProveedor = "idproveedor!='$idproveedor'";
$dataProveedores = CRUD('proveedores', '*', $condProveedor, '', '', 'SC');

$categoria = buscavalor('categorias', 'categoria', 'idcategoria="' . $idcategoria . '"');
$condCategoria = "idcategoria!='$idcategoria'";
$dataCategorias = CRUD('categorias', '*', $condCategoria, '', '', 'SC');
?>
<input type="hidden" id="accion" name="accion" value="udpate">
<input type="hidden" name="idproducto" value="<?php echo $idproducto; ?>">
<input type="hidden" name="num" value="<?php echo $num; ?>">
<input type="hidden" name="old_img" value="<?php echo $imagen; ?>">
<input type="hidden" name="num_reg" value="<?php echo $num_reg; ?>">
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Producto:</b></span>
            <textarea class="form-control" name="producto" required><?php echo $producto; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Detalle:</b></span>
            <textarea class="form-control" name="detalle" required><?php echo $detalle; ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Precio:</b></span>
            <input type="text" class="form-control" name="precio" value="<?php echo $precio; ?>" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Stock:</b></span>
            <input type="text" class="form-control" name="stock" value="<?php echo $stock; ?>" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01"><b>Categoría:</b></label>
            <select class="form-select" id="idcategoria" name="idcategoria">
                <option value="<?php echo $idcategoria; ?>" selected><?php echo $categoria; ?></option>
                <?php foreach ($dataCategorias as $result): ?>
                    <option value="<?php echo $result['idcategoria']; ?>"><?php echo $result['categoria']; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01"><b>Proveedores</b></label>
            <select class="form-select" id="idproveedor" name="idproveedor">
                <option value="<?php echo $idproveedor; ?>" selected><?php echo $proveedor; ?></option>
                <?php foreach ($dataProveedores as $result): ?>
                    <option value="<?php echo $result['idproveedor']; ?>"><?php echo $result['proveedor']; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="imageUpload" name="imagen" accept="image/*">
            <label class="input-group-text" for="inputGroupFile02"><b>Imagen:</b></label>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p><b>Imagen Actual</b></p>
                <img src="./public/img/productos/<?php echo $imagen; ?>" width="200px" alt="">
            </div>
            <div class="col-md-6">
                <p><b>Imagen Nueva</b></p>
                <img id="imagePreview" class="preview-img" width="300px">
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    // Previsualizar imagen
    $('#imageUpload').change(function(event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).show();
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    });
});
</script>