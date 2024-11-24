<div class="row">
    <div class="col-md-3" style="margin-bottom: 5px;">
        <div class="card">
            <div class="card-header colorNavbar">
                <b>Acceso Módulos</b>
            </div>
            <div class="card-body">
                <a href="" class="btn btnInternos Acceso-Panel-Usuario"><b>Usuarios</b></a>
                &nbsp;
                <a href="" class="btn btnInternos Acceso-Panel-Rol"><b>Roles</b></a>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header colorNavbar">
                <b>Resultados</b>
            </div>
            <div class="card-body" id="DataPanelUsuariosRoles">

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".Acceso-Panel-Usuario").click(function() {
            $("#DataPanelUsuariosRoles").load("./views/usuarios/usuarios.php");
            return false;
        });

        $(".Acceso-Panel-Rol").click(function() {
            $("#DataPanelUsuariosRoles").load("./views/usuarios/roles.php");
            return false;
        });
    });
</script>
