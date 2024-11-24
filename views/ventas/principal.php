<?php
session_start();
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';
$idusuario = $_SESSION['idusuario'];
$tipo = $_SESSION['tipo'];
if (isset($_POST['idcategoria'])) {
    $val_cond = "idcategoria='" . $_POST['idcategoria'] . "'";
    $dataProductos = CRUD('productos', '*', $val_cond, '', '', 'SC') ?? [];
} else {
    $dataProductos = CRUD('productos', '*', '', '', '', 'S') ?? [];
}
$productosCarrito = buscavalor("carrito", "SUM(cantidad)", "idusuario='$idusuario' AND estado=0");
$dataCategorias = CRUD('categorias', '*', '', '', '', 'S') ?? [];
?>
<div id="Data-Ventas" style="margin-top: 5px;">
    <div class="row">
        <div class="col-md-4">
            <div class="input-group mb-3" style="width: 400px;">
                <label class="input-group-text" for="inputGroupSelect01"><b>Categorías</b></label>
                <select class="form-select" id="idcategoria" name="idcategoria">
                    <option disabled selected>Seleccione Categoría</option>
                    <?php foreach ($dataCategorias as $result): ?>
                        <option value="<?php echo $result['idcategoria']; ?>"><?php echo $result['categoria']; ?></option>
                    <?php endforeach ?>
                </select>
                <a class="btn btn-succes btn-outline-success" id="BtnBuscaCategoria" type="button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
            </div>
        </div>
        <div class="col-md-2">
            <?php if ($tipo == 1 || $tipo == 2): ?>
                <a href="" class="btn btn-warning btn-sm ReloadVentas">
                    <i class="fa-solid fa-repeat"></i>
                </a>
            <?php endif ?>
        </div>
        <div class="col-md-6" style="text-align: end;">
            <a href="" class="btn btn-primary btn-sm VerCarrito">
                <b><?php echo $productosCarrito; ?></b>
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    </div>



    <?php if ($dataProductos): ?>
        <div class="row">
            <?php foreach ($dataProductos as $result): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <b><?php echo $result['nombre']; ?></b>
                            <br>
                            <img src="./public/img/productos/<?php echo $result['imagen']; ?> ?>" class="img-fluid" alt="">
                            <p><b>Detalle:</b> <?php echo $result['detalle']; ?></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Precio: $</b> <?php echo $result['precio']; ?>
                                </div>
                                <div class="col-md-6">
                                    <b>Stock:</b> <?php echo $result['stock']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">

                            <div class="input-group mb-3">
                                <input type="number" min="0" max="<?php echo $result['stock']; ?>" class="form-control" value="0" id="cantidad-<?php echo $result['idproducto']; ?>">
                                <a class="btn btn-outline-success BtnAddCar" idproducto="<?php echo $result['idproducto']; ?>">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <b>No se encuentras productos para la categoría seleccionada</b>
        </div>
    <?php endif ?>
</div>
<?php if (isset($_POST['msj'])): ?>
    <script>
        $(document).ready(function() {
            alertify.alert("Ventas", "<?php echo $_POST['msj']; ?>");
            return false;
        });
    </script>
<?php endif ?>
<script>
    $(document).ready(function() {
        /* Recargar Panel Ventas */
        $(".ReloadVentas").click(function() {
            $("#data").load('./views/ventas/principal.php');
            return false;
        });
        /* Buscador por Categoría */
        $("#BtnBuscaCategoria").click(function() {
            let idcategoria = $("#idcategoria").val();
            let tipo = "<?php echo $tipo; ?>";
            if (idcategoria == null) {
                alertify.alert("Ventas", "Favor seleccionar la categoría a buscar...");
            } else {
                if (tipo == 1 || tipo == 2) {
                    $.ajax({
                        url: './views/ventas/principal.php',
                        type: 'post',
                        data: {
                            idcategoria: idcategoria
                        },
                        success: function(response) {
                            $("#data").html(response);
                        }
                    });
                } else {
                    $.ajax({
                        url: './views/ventas/principal.php',
                        type: 'post',
                        data: {
                            idcategoria: idcategoria
                        },
                        success: function(response) {
                            $("#Data-Ventas").html(response);
                        }
                    });
                }

            }
            return false;
        });
        /* Agregar Producto a Carrito */
        $(".BtnAddCar").click(function() {
            let idproducto, cantidad;
            idproducto = $(this).attr("idproducto");
            cantidad = $("#cantidad-" + idproducto).val();
            if (cantidad == 0) {
                alertify.alert("Ventas", "Favor ingresar una cantidad del producto válida...");
                return false;
            } else {
                alertify.confirm('Ventas', 'Seguro/a de agregar producto a carrito ....', function() {
                    $.ajax({
                        url: './views/ventas/carrito.php',
                        type: 'post',
                        data: {
                            idproducto: idproducto,
                            cantidad: cantidad
                        },
                        success: function(response) {
                            $("#Data-Ventas").html(response);
                        }
                    });
                }, function() {});
            }
            return false;
        });
        /* Ver Carrito */
        $(".VerCarrito").click(function() {
            $("#Data-Ventas").load("./views/ventas/preventa.php");
            return false;
        });
    });
</script>