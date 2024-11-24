<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Nombres:</b></span>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Apellidos:</b></span>
            <input type="text" class="form-control" name="apellido" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Tetefono:</b></span>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Correo:</b></span>
            <textarea class="form-control" name="correo" required></textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>DUI:</b></span>
            <input type="text" class="form-control" id="dui" name="dui" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Dirección:</b></span>
            <textarea class="form-control" name="direccion" required></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Usuario:</b></span>
            <input type="text" class="form-control" id="usuario" name="usuario" required readonly>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><b>Clave</b></span>
            <input type="password" class="form-control" name="clave" required>
        </div>
    </div>
</div>
<script>
    Inputmask("99999999-9").mask(document.getElementById("dui"));
    Inputmask("9999-9999").mask(document.getElementById("telefono"));
    $(document).ready(function() {
        $("#dui").on("keyup change", function() {
            let dui = $("#dui").val();

            // Eliminar los guiones de la cadena del campo 'dui'
            let usuario = dui.replace(/-/g, "");

            // Asignar el valor sin guiones al campo 'usuario'
            $("#usuario").val(usuario);

            return false;
        });
    });
</script>