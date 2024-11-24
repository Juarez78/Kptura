<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';
$dataRoles = CRUD('roles', '*', '', '', '', 'S');
?>
<input type="hidden" name="accion" id="accion" value="insert">
<div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1"><b>Usuario:</b></span>
    <input type="text" class="form-control" name="usuario" required>
</div>
<div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1"><b>Clave</b></span>
    <input type="password" class="form-control" name="clave" required>
</div>
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupSelect01"><b>Tipo/Rol</b></label>
    <select class="form-select" id="tipo-rol-I" name="tipo">
        <option disabled selected>Seleccione Tipo/Rol</option>
        <?php foreach ($dataRoles as $result): ?>
            <option value="<?php echo $result['idrol']; ?>"><?php echo $result['idrol'].') '.$result['rol']; ?></option>
        <?php endforeach ?>
    </select>
</div>