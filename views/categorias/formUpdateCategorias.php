<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

$idcategoria = $_GET['idcategoria'];
$num = $_GET['num'];
$num_reg = $_GET['num_reg'];
$condicion = "idcategoria='$idcategoria'";
$dataCategoria = CRUD('categorias', '*', $condicion, '', '', 'SC');
foreach ($dataCategoria as $result) {
    $categoria = $result['categoria'];
    $estado = $result['estado'];
}
$vestado = ($estado == 1) ? 'Habilitado' : 'Deshabilitado';
?>
<input type="hidden" id="accion" name="accion" value="udpate">
<input type="hidden" name="idcategoria" value="<?php echo $idcategoria; ?>">
<input type="hidden" name="num" value="<?php echo $num; ?>">
<input type="hidden" name="num_reg" value="<?php echo $num_reg; ?>">
<div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1"><b>Categoría:</b></span>
    <input type="text" class="form-control" name="categoria" value="<?php echo $categoria; ?>" required>
</div>
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupSelect01"><b>Estado</b></label>
    <select class="form-select" id="estado" name="estado">
        <option value="<?php echo $estado; ?>" selected><?php echo $vestado; ?></option>
        <option value="<?php echo ($result['estado'] == 1) ? 0 : 1; ?>">
            <?php echo ($result['estado'] == 1) ? 'Deshabilitar' : 'Habilitar'; ?>
        </option>
    </select>
</div>