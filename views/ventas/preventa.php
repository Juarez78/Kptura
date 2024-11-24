<?php
session_start();
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';
$idusuario = $_SESSION['idusuario'];
$tipo = $_SESSION['tipo'];
$val_cond = "estado=0 && idusuario='$idusuario'";
$dataCarrito = CRUD('carrito', '*', $val_cond, '', '', 'SC') ?? [];
$cont = 0;
$total = 0;
$contTotal = 0;
$contCantidad = 0;
?>
<div class="table-responsive">
    <a class="btn btn-primary btn-sm" id="Panel-Venta" tipo="<?php echo $tipo; ?>" style="margin-bottom: 5px;">
        <i class="fa-solid fa-circle-left"></i>
    </a>
    <?php if ($dataCarrito): ?>
        <hr>
        <form id="SaveDataCarrito">
            <table class="table table-bordeless" style="margin: 0 auto; width: 80%;">
                <thead>
                    <tr>
                        <th class="centrar">Nº</th>
                        <th class="centrar">Producto</th>
                        <th class="centrar">Precio <br>Unitario</th>
                        <th class="centrar">Cantidad</th>
                        <th class="centrar">Subtotal</th>
                        <th class="centrar">Borrar</th>
                    </tr>
                </thead>
                <tbody class="centrar">
                    <?php foreach ($dataCarrito as $result): ?>
                        <input type="hidden" name="idcarrito[]" value="<?php echo $result['idcarrito']; ?>">
                        <tr>
                            <td><?php echo $cont += 1; ?></td>
                            <td><?php echo buscavalor('productos', 'nombre', 'idproducto="' . $result['idproducto'] . '"'); ?></td>
                            <td>
                                $ <?php echo $precio = buscavalor('productos', 'precio', 'idproducto="' . $result['idproducto'] . '"'); ?>
                            </td>
                            <td>
                                <?php
                                echo $cantidad = $result['cantidad'];
                                $contCantidad += $cantidad;
                                ?>
                            </td>
                            <td>
                                $ <?php
                                    echo $total += ($precio * $cantidad);
                                    $contTotal += $total;
                                    ?>
                            </td>
                            <td>
                                <a class="btn btn-danger btn-sm DelCarrito" idcarrito="<?php echo $result['idcarrito']; ?>" idproducto="<?php echo $result['idproducto']; ?>" cantidad="<?php echo $result['cantidad']; ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td colspan="3" class="centrar"><b>Total</b></td>
                        <td>
                            <?php echo $contCantidad; ?>
                        </td>
                        <td>
                            $ <?php echo $contTotal; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php if ($tipo == 1 || $tipo == 2): ?>
                <button class="btn btn-primary"><b>Pagar</b></button>
            <?php else: ?>
                <button class="btn btn-primary"><b>Realizar Pedido</b></button>
            <?php endif ?>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">
            <b>No se encuentran productos agregados a carrito.....</b>
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
        /* Modulo Ventas */
        $("#Panel-Venta").click(function() {
            let tipo = $(this).attr('tipo');
            if (tipo == 1 || tipo == 2) {
                $("#data").load("./views/ventas/principal.php");
            } else {
                window.location.href = "index.php";
            }
            return false;
        });
        /* Borrar Producto del Carrito */
        $(".DelCarrito").click(function() {
            let idcarrito = $(this).attr('idcarrito');
            let idproducto = $(this).attr('idproducto');
            let cantidad = $(this).attr('cantidad');
            let tipo = $(this).attr('tipo');
            alertify.confirm('Ventas', 'Seguro/a de eliminar producto de carrito ....', function() {
                $.ajax({
                    url: './views/ventas/delcarrito.php',
                    type: 'POST',
                    data: {
                        idcarrito: idcarrito,
                        idproducto: idproducto,
                        cantidad: cantidad
                    },
                    success: function(response) {
                        $("#Data-Ventas").html(response);
                    }
                });
            }, function() {});

            return false;
        });
        /* Realizar Pago ó Pedido*/
        $("#SaveDataCarrito").on("submit", function(e) {
            e.preventDefault();
            let formData = new FormData(document.getElementById("SaveDataCarrito"));

            formData.append("dato", "valor");
            $.ajax({
                url: "./views/ventas/procesar.php",
                type: "post",
                dataType: "html",
                cache: false,
                contentType: false,
                processData: false,
                data: formData
            }).done(function(result) {
                $("#Data-Ventas").html(result);
            });
            return false;
        });
    });
</script>