<div class="row">
    <div class="col-md-4 col-md-auto" style="margin-bottom: 5px;">
        <a href="" class="btn btnAdmin btn-sm" id="Panel-Usuarios">Usuarios</a>
        <a href="" class="btn btnAdmin btn-sm" id="Panel-Categorias">Categorías</a>
        <a href="" class="btn btnAdmin btn-sm" id="Panel-Proveedores">Proveedores</a>
    </div>
    <div class="col-md-4 col-md-auto" style="margin-bottom: 5px;">
        <a href="" class="btn btnAdmin btn-sm" id="Panel-Productos">Productos</a>
        <a href="" class="btn btnAdmin btn-sm" id="Panel-Ticket">Ticket</a>
        <a href="" class="btn btnAdmin btn-sm" id="Panel-Ventas">Ventas</a>
    </div>
    <div class="col-md-4 col-md-auto">
        <a href="" class="btn btnAdmin btn-sm" id="Panel-Clientes">Clientes</a>
        <a href="" class="btn btnAdmin btn-sm" id="Panel-Empleados">Empleados</a>
        <a href="" class="btn btnAdmin btn-sm" id="Panel-">Administración</a>
    </div>
</div>
<script>
    $(document).ready(function() {
        /* Modulo Usuarios */
        $("#Panel-Usuarios,.Panel-Usuarios").click(function() {
            $("#data").load("./views/usuarios/principal.php");
            $("#ModalModulos").modal("hide");
            return false;
        });
        /* Modulo Categorias */
        $("#Panel-Categorias,.Panel-Categorias").click(function() {
            $("#data").load("./views/categorias/principal.php");
            $("#ModalModulos").modal("hide");
            return false;
        });
        /* Modulo Clientes */
        $("#Panel-Clientes,.Panel-Clientes").click(function() {
            $("#data").load("./views/clientes/principal.php");
            $("#ModalModulos").modal("hide");
            return false;
        });
        /* Modulo Productos */
        $("#Panel-Productos,.Panel-Productos").click(function() {
            $("#data").load("./views/productos/principal.php");
            $("#ModalModulos").modal("hide");
            return false;
        });
        /* Modulo Ventas */
        $("#Panel-Ventas,.Panel-Ventas").click(function() {
            $("#data").load("./views/ventas/principal.php");
            $("#ModalModulos").modal("hide");
            return false;
        });
        /* Modulo Ticket */
        $("#Panel-Ticket,.Panel-Ticket").click(function() {
            $("#data").load("./views/tickets/principal.php");
            $("#ModalModulos").modal("hide");
            return false;
        });
    });
</script>
