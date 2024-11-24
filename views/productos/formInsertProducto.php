<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';
$dataProveedores = CRUD('proveedores', '*', '', '', '', 'S');
$dataCategorias = CRUD('categorias', '*', '', '', '', 'S');
$idproducto = MaxID('productos','idproducto')+1;
?>
<input type="hidden" name="accion" id="accion" value="insert">
<input type="hidden" name="idproducto" id="idproducto" value="<?php echo $idproducto;?>">
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Producto:</b></span>
            <textarea class="form-control" name="producto" required></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Detalle:</b></span>
            <textarea class="form-control" name="detalle" required></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Precio:</b></span>
            <input type="text" class="form-control" name="precio" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Stock:</b></span>
            <input type="text" class="form-control" name="stock" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01"><b>Categoría:</b></label>
            <select class="form-select" id="idcategoria" name="idcategoria">
                <option disabled selected>Seleccione Categoría</option>
                <?php foreach ($dataCategorias as $result): ?>
                    <option value="<?php echo $result['idcategoria']; ?>"><?php echo $result['categoria']; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01"><b>Proveedores</b></label>
            <select class="form-select" id="idproveedor" name="idproveedor">
                <option disabled selected>Seleccione Proveedor</option>
                <?php foreach ($dataProveedores as $result): ?>
                    <option value="<?php echo $result['idproveedor']; ?>"><?php echo $result['proveedor']; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="imageUpload" name="imagen" accept="image/*">
            <label class="input-group-text" for="inputGroupFile02"><b>Imagen:</b></label>
        </div>
        <img id="imagePreview" class="preview-img" width="300px">
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