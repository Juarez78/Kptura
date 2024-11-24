<div class="contenedor-center">
    <div class="centrar">
        <h5><b>Iniciar Sesión</b></h5>
        <form id="Data-Login">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-circle-user"></i>
                </span>
                <input type="text" class="form-control" placeholder="Usuario" required name="user">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-key"></i>
                </span>
                <input type="password" class="form-control" placeholder="Contraseña" required name="passw">
            </div>
            <div class="centrar">
                <button class="btn btn-primary"><i class="fa-solid fa-right-to-bracket"></i><b> Acceder</b></button>
            </div>
        </form>
        <br>
        <a class="btn" id="new-cliente" style="background-color: #39774e; color: white;">
            <i class="fa-solid fa-user-plus"></i> <b> Registrate</b>
        </a>
    </div>
</div>
<div id="nuevoCliente"></div>
<?php
include './modals/modulos.php';
?>
<?php if (isset($_POST['msj'])): ?>
    <script>
        $(document).ready(function() {
            alertify.alert("Usuario", "<?php echo $_POST['msj']; ?>");
            return false;
        });
    </script>
<?php endif ?>
<script>
    $(document).ready(function() {
        $("#Data-Login").on("submit", function(e) {
            e.preventDefault();
            let formData = new FormData(document.getElementById("Data-Login"));

            formData.append("dato", "valor");
            $.ajax({
                url: "./controllers/login.php",
                type: "post",
                dataType: "html",
                cache: false,
                contentType: false,
                processData: false,
                data: formData
            }).done(function(result) {
                $("#principal").html(result);
            });
            return false;
        });
        /* Modal Formulario Registro Nuevo Cliente */
        $("#new-cliente").click(function() {
            $("#Modal-IU").modal("show");
            $('#mimodal').addClass('modal-lg');
            $("#Data-IU").load("./views/clientes/formInsertClienteLogin.php");
            // Obtener el elemento por su ID y cambiar el texto
            document.getElementById("titulo-header-IU").innerText = "Registro Nuevo Cliente";
            document.getElementById("btn-accion-IU").innerText = "Guardar";
            return false;
        });
        /* Proceso de Insert ó Update Categoría */
        $("#Acciones-IU").click(function() {
            let nombre = $('[name="nombre"]').val();
            let apellido = $('[name="apellido"]').val();
            let dui = $('[name="dui"]').val();
            let correo = $('[name="correo"]').val();
            let telefono = $('[name="telefono"]').val();
            let direccion = $('[name="direccion"]').val();
            let usuario = $('[name="usuario"]').val();
            let clave = $('[name="clave"]').val();
            $.ajax({
                url: "./views/clientes/insertLogin.php",
                type: "POST",
                dataType: "html",
                data: {
                    nombre: nombre,
                    apellido: apellido,
                    correo: correo,
                    telefono: telefono,
                    direccion: direccion,
                    dui: dui,
                    usuario: usuario,
                    clave: clave
                },
                success: function(result) {
                    $("#Modal-IU").modal("hide");
                    $("#principal").html(result);
                }
            });

            return false;
        });
    });
</script>