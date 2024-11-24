<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';
?>
<input type="hidden" name="accion" id="accion" value="insert">
<div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1"><b>Categoría:</b></span>
    <input type="text" class="form-control" name="categoria" required>
</div>