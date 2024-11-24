<?php
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';

if (isset($_POST['num'])) {
    $pagina = $_POST['num'];
} else {
    $pagina = 0;
}

if (isset($_POST['num_reg'])) {
    $registros = $_POST['num_reg'];
} else {
    $registros = 5;
}

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $registros;
}

if (isset($_POST['idcategoria'])) {
    $idcategoria = $_POST['idcategoria'];
    $condicion = "idcategoria='$idcategoria' ORDER BY nombre ASC";
    $dataProductos = CRUD('productos', '*', $condicion, '', '', 'SC');
    $query = 'SELECT * FROM productos WHERE idcategoria="' . $idcategoria . '" ORDER BY nombre ASC';
} elseif (isset($_POST['valor'])) {
    $valor = $_POST['valor'];
    $condicion = "nombre LIKE '%$valor%' ORDER BY nombre ASC";
    $dataProductos = CRUD('productos', '*', $condicion, '', '', 'SC');
    $query = 'SELECT * FROM productos WHERE nombre LIKE "%' . $valor . '%" ORDER BY nombre ASC';
} else {
    $tabla = "productos LIMIT $inicio,$registros";
    $dataProductos = CRUD($tabla, '*', '', '', '', 'S') ?? [];
    $query = "SELECT * FROM productos";
}

$dataCategorias = CRUD('categorias', '*', '', '', '', 'S') ?? [];
$dataProveedores = CRUD('proveedores', '*', '', '', '', 'S') ?? [];
$num_regisros = CountReg($query);
$paginas = ceil($num_regisros / $registros);
$cont = 0;
?>
<div class="card">
    <div class="card-header colorNavbar">
        <b>Panel Productos</b>
    </div>
    <div class="card-body" id="DataPanelProductos">
        <div class="table-responsive-xl">
            <div class="row">
                <div class="col-md-6">
                    <a href="" class="btn btn-primary btn-sm" id="ModalInsertProducto">
                        <i class="fa-solid fa-circle-plus"></i>
                    </a>
                    <a href="" class="btn btn-warning btn-sm ReloadProductos">
                        <i class="fa-solid fa-repeat"></i>
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3" style="width: 400px;">
                        <label class="input-group-text" for="inputGroupSelect01"><b>Categorías</b></label>
                        <select class="form-select" id="idcategoria1" name="idcategoria1">
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
            </div>
            <hr>
            <?php if ($dataProductos): ?>
                <table class="table table-borderless TableUsuarios">
                    <thead class="centrar">
                        <tr>
                            <th>Nº</th>
                            <th>Producto</th>
                            <th>Detalle</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Proveedor</th>
                            <th>Categoría</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="centrar">
                        <?php foreach ($dataProductos as $result): ?>
                            <?php
                            $BuscaProducto = buscavalor("carrito", "COUNT(idproducto)", "idproducto='".$result['idproducto']."'");
                            ?>
                            <tr>
                                <td class="centrar"><?php echo $cont += 1; ?></td>
                                <td class="centrar">
                                    <img src="./public/img/productos/<?php echo $result['imagen']; ?>" width="200px" alt="">
                                    <br>
                                    <?php echo $result['nombre']; ?>
                                </td>
                                <td><?php echo $result['detalle']; ?></td>
                                <td>$<?php echo $result['precio']; ?></td>
                                <td><?php echo $result['stock']; ?></td>
                                <td><?php echo buscavalor('proveedores', 'proveedor', 'idproveedor="' . $result['idproveedor'] . '"'); ?></td>
                                <td><?php echo buscavalor('categorias', 'categoria', 'idcategoria="' . $result['idcategoria'] . '"'); ?></td>
                                <td class="centrar">
                                    <?php if($BuscaProducto != 0):?>
                                    <a href="" class="btn btn-sm btn-danger BtnDelProducto btnBloqueado" idproducto="<?php echo $result['idproducto']; ?>">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                    <?php else:?>
                                        <a href="" class="btn btn-sm btn-danger BtnDelProducto" idproducto="<?php echo $result['idproducto']; ?>">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                    <?php endif ?>
                                </td>
                                <td class="centrar">
                                    <a href="" class="btn btn-sm btn-success BtnModalUpdateProducto" idproducto="<?php echo $result['idproducto']; ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php if ($num_regisros > $registros) : ?>
                    <?php if ($pagina == 1) : ?>
                        <div style="text-align: center;">
                            <a href="" class="btn btn-sm btnBloqueado" v-num="<?php echo ($pagina - 1); ?>" num-reg="<?php echo $registros; ?>">
                                <i class="fa-solid fa-circle-left fa-2x"></i>
                            </a>

                            <a href="" class="btn pagina btn-sm btnPaginadoActivo" v-num="<?php echo ($pagina + 1); ?>" num-reg="<?php echo $registros; ?>">
                                <i class="fa-solid fa-circle-right fa-2x"></i>
                            </a>
                        </div>
                    <?php elseif ($pagina == $paginas) : ?>
                        <div style="text-align: center;">
                            <a href="" class="btn pagina btn-sm btnPaginadoActivo" v-num="<?php echo ($pagina - 1); ?>" num-reg="<?php echo $registros; ?>">
                                <i class="fa-solid fa-circle-left fa-2x"></i>
                            </a>
                            <a href="" class="btn btn-sm btnBloqueado" v-num="<?php echo ($pagina + 1); ?>" num-reg="<?php echo $registros; ?>">
                                <i class="fa-solid fa-circle-right fa-2x"></i>
                            </a>
                        </div>
                    <?php else : ?>
                        <div style="text-align: center;">
                            <a href="" class="btn pagina btn-sm btnPaginadoActivo" v-num="<?php echo ($pagina - 1); ?>" num-reg="<?php echo $registros; ?>">
                                <i class="fa-solid fa-circle-left fa-2x"></i>
                            </a>

                            <a href="" class="btn pagina btn-sm btnPaginadoActivo" v-num="<?php echo ($pagina + 1); ?>" num-reg="<?php echo $registros; ?>">
                                <i class="fa-solid fa-circle-right fa-2x"></i>
                            </a>
                        </div>
                    <?php endif ?>
                <?php endif ?>
                <div class="alert colorNavbar" style="text-align:center;margin-top:15px;color:white;">
                    <?php echo "<b>P&aacute;gina: " . $pagina . ' / ' . $paginas . "</b>"; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    <b>No se encuentran productos registrados....</b>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?php if (isset($_POST['msj'])): ?>
    <script>
        $(document).ready(function() {
            alertify.alert("Productos", "<?php echo $_POST['msj']; ?>");
            return false;
        });
    </script>
<?php endif ?>
<script>
    $(document).ready(function() {
        /* Paginado */
        $(".pagina").click(function() {
            let num, reg, rol_tipo;
            num = $(this).attr("v-num");
            reg = $(this).attr("num-reg");
            rol_tipo = '<?php echo $rol_tipo; ?>';
            if (rol_tipo != 0) {
                $.ajax({
                    url: './views/productos/principal.php',
                    type: 'post',
                    data: {
                        num: num,
                        num_reg: reg,
                        rol_tipo: rol_tipo
                    },
                    success: function(response) {
                        $("#data").html(response);
                    }
                });
            } else {
                $.ajax({
                    url: './views/productos/principal.php',
                    type: 'post',
                    data: {
                        num: num,
                        num_reg: reg
                    },
                    success: function(response) {
                        $("#data").html(response);
                    }
                });
            }
            return false;
        });

        /* Buscador por Categoría */
        $("#BtnBuscaCategoria").click(function() {
            let idcategoria = $("#idcategoria1").val();
            if (idcategoria == null) {
                alertify.alert("Productos", "Favor seleccionar la categoría a buscar...");
            } else {
                $.ajax({
                    url: './views/productos/principal.php',
                    type: 'post',
                    data: {
                        idcategoria: idcategoria
                    },
                    success: function(response) {
                        $("#data").html(response);
                    }
                });
            }
            return false;
        });

        /* Recargar Panel Productos */
        $(".ReloadProductos").click(function() {
            $("#data").load('./views/productos/principal.php');
            return false;
        });


        /* Modal Insertar Productos */
        $("#ModalInsertProducto").click(function() {
            $("#Modal-IU").modal("show");
            $('#mimodal').addClass('modal-lg');
            $("#Data-IU").load("./views/productos/formInsertProducto.php");
            // Obtener el elemento por su ID y cambiar el texto
            document.getElementById("titulo-header-IU").innerText = "Registrar Producto";
            document.getElementById("btn-accion-IU").innerText = "Guardar";
            return false;
        });


        /* Formulario Actualizar Usuario */
        $(".BtnModalUpdateProducto").click(function() {
            let idproducto = $(this).attr("idproducto");
            let num, reg;
            num = '<?php echo $pagina; ?>';
            reg = '<?php echo $registros; ?>';
            $("#Modal-IU").modal("show");
            $('#mimodal').addClass('modal-xl');
            $("#Data-IU").load("./views/productos/formUpdateProducto.php?idproducto=" + idproducto + "&num=" + num + "&num_reg=" + reg);
            document.getElementById("titulo-header-IU").innerText = "Actualizar Usuario";
            document.getElementById("btn-accion-IU").innerText = "Actualizar";
            return false;
        });


        /* Proceso de Insert ó Update Usuario */
        $("#Acciones-IU").click(function() {
            let accion = $("#accion").val();
            let idproducto = $('[name="idproducto"]').val();
            let producto = $('[name="producto"]').val();
            let detalle = $('[name="detalle"]').val();
            let precio = $('[name="precio"]').val();
            let stock = $('[name="stock"]').val();
            let idcategoria = $('[name="idcategoria"]').val();
            let idproveedor = $('[name="idproveedor"]').val();
            let imagen = $('[name="imagen"]')[0].files[0]; // Obtener el archivo de imagen
            let num = $('[name="num"]').val();
            let num_reg = $('[name="num_reg"]').val();

            // Validación antes de enviar
            if (accion == "insert") {
                if (!producto || producto.trim() === "") {
                    alertify.alert("Registro Producto", "Favor de ingresar el nombre del producto.");
                } else if (!detalle || detalle.trim() === "") {
                    alertify.alert("Registro Producto", "Favor de ingresar el detalle del producto.");
                } else if (!precio || isNaN(precio) || precio <= 0) {
                    alertify.alert("Registro Producto", "Favor de ingresar un precio válido.");
                } else if (!stock || isNaN(stock) || stock <= 0) {
                    alertify.alert("Registro Producto", "Favor de ingresar un stock válido.");
                } else if (!idcategoria || idcategoria === "") {
                    alertify.alert("Registro Producto", "Favor de seleccionar la categoría.");
                } else if (!idproveedor || idproveedor === "") {
                    alertify.alert("Registro Producto", "Favor de seleccionar el proveedor.");
                } else if (!imagen) {
                    alertify.alert("Registro Producto", "Favor de seleccionar una imagen para el producto.");
                } else {
                    // Crear el objeto FormData para enviar datos y archivo
                    let formData = new FormData();
                    formData.append("idproducto", idproducto);
                    formData.append("producto", producto);
                    formData.append("detalle", detalle);
                    formData.append("precio", precio);
                    formData.append("stock", stock);
                    formData.append("idcategoria", idcategoria);
                    formData.append("idproveedor", idproveedor);
                    formData.append("imagen", imagen); // Añadir archivo de imagen al FormData
                    formData.append("num", num);
                    formData.append("num_reg", num_reg);

                    // Enviar datos por Ajax
                    $.ajax({
                        url: "./views/productos/insert.php",
                        type: "POST",
                        dataType: "html",
                        data: formData,
                        contentType: false, // No establecer el tipo de contenido para FormData
                        processData: false, // No procesar los datos (para que se envíen correctamente como multipart)
                        success: function(result) {
                            $("#Modal-IU").modal("hide");
                            $("#DataPanelProductos").html(result);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error en la solicitud Ajax:", error);
                        }
                    });
                }
            } else {
                let formData = new FormData();
                formData.append("idproducto", idproducto);
                formData.append("producto", producto);
                formData.append("detalle", detalle);
                formData.append("precio", precio);
                formData.append("stock", stock);
                formData.append("idcategoria", idcategoria);
                formData.append("idproveedor", idproveedor);
                formData.append("imagen", imagen); // Añadir archivo de imagen al FormData
                formData.append("num", num);
                formData.append("num_reg", num_reg);
                $.ajax({
                    url: "./views/productos/update.php",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    contentType: false, // No establecer el tipo de contenido para FormData
                    processData: false, // No procesar los datos (para que se envíen correctamente como multipart)
                    success: function(result) {
                        $("#Modal-IU").modal("hide");
                        $("#DataPanelProductos").html(result);
                    }
                });
            }
            return false;
        });



        /* Borrar Producto */
        $(".BtnDelProducto").click(function() {
            let idproducto = $(this).attr("idproducto");
            let num, reg;
            num = '<?php echo $pagina; ?>';
            reg = '<?php echo $registros; ?>';
            alertify.confirm('Productos', 'Seguro/a de eliminar producto ....', function() {
                $.ajax({
                    url: './views/productos/del.php',
                    type: 'post',
                    data: {
                        idproducto: idproducto,
                        num: num,
                        num_reg: reg
                    },
                    success: function(response) {
                        $("#DataPanelProductos").html(response);
                    }
                });
            }, function() {});

            return false;
        });
    });
</script>