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

if (isset($_POST['valor'])) {
    $valor = $_POST['valor'];
    $condicion = "categoria LIKE '%$valor%' ORDER BY categoria ASC $inicio,$registros";
    $dataCategorias = CRUD('categorias', '*', $condicion, '', '', 'SC');
    $query = 'SELECT * FROM categorias WHERE categoria LIKE "%' . $valor . '%" ORDER BY categoria ASC LIMIT';
} else {
    $rol_tipo = 0;
    $tabla = "categorias LIMIT $inicio,$registros";
    $dataCategorias = CRUD($tabla, '*', '', '', '', 'S');
    $query = "SELECT * FROM categorias";
}

$num_regisros = CountReg($query);
$paginas = ceil($num_regisros / $registros);
$cont = 0;
?>
<div class="card">
    <div class="card-header colorNavbar">
        <b>Panel Categorías</b>
    </div>
    <div class="card-body" id="DataPanelCategorias">
        <div class="table-responsive-xl">
            <div class="row">
                <div class="col-md-6">
                    <a href="" class="btn btn-primary btn-sm" id="ModalInsertCategoria">
                        <i class="fa-solid fa-circle-plus"></i>
                    </a>
                    <a href="" class="btn btn-warning btn-sm ReloadCategorias"><i class="fa-solid fa-repeat"></i></a>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <hr>
            <?php if ($dataCategorias): ?>
                <table class="table table-borderless TableCategorias">
                    <thead class="centrar">
                        <tr>
                            <th>Nº</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="centrar">
                        <?php foreach ($dataCategorias as $result): ?>
                            <tr>
                                <td><?php echo $cont += 1; ?></td>
                                <td><?php echo $result['categoria']; ?></td>
                                <td><?php echo ($result['estado'] == 1) ? 'Habilitado' : 'Deshabilitado'; ?></td>
                                <td>
                                    <a href="" class="btn btn-sm btn-success BtnModalUpdateCategoria" idcategoria="<?php echo $result['idcategoria']; ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="" class="btn btn-sm btn-danger BtnDelCategoria" idcategoria="<?php echo $result['idcategoria']; ?>">
                                        <i class="fa-solid fa-trash"></i>
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
                <div class="alert alert-success">
                    <b>No se encuentran datos registrados.....</b>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?php if (isset($_POST['msj'])): ?>
    <script>
        $(document).ready(function() {
            alertify.alert("Usuarios", "<?php echo $_POST['msj']; ?>");
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
                    url: './views/categorias/principal.php',
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
                    url: './views/categorias/principal.php',
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
            let num, reg;
            num = '<?php echo $pagina; ?>';
            reg = '<?php echo $registros; ?>';
            let vcategoria = $("#vcategoria").val();
            $.ajax({
                url: './views/categorias/principal.php',
                type: 'post',
                data: {
                    vcategoria: vcategoria,
                    num: num,
                    num_reg: reg
                },
                success: function(response) {
                    $("#data").html(response);
                }
            });
        });

        /* Recargar Panel categorias */
        $(".ReloadCategorias").click(function() {
            $("#data").load('./views/categorias/principal.php');
            return false;
        });


        /* Modal Insertar Categoria */
        $("#ModalInsertCategoria").click(function() {
            $("#Modal-IU").modal("show");
            $("#Data-IU").load("./views/categorias/formInsertCategorias.php");
            // Obtener el elemento por su ID y cambiar el texto
            document.getElementById("titulo-header-IU").innerText = "Registrar Categoría";
            document.getElementById("btn-accion-IU").innerText = "Guardar";
            return false;
        });


        /* Formulario Actualizar Categoria */
        $(".BtnModalUpdateCategoria").click(function() {
            let idcategoria = $(this).attr("idcategoria");
            let num, reg;
            num = '<?php echo $pagina; ?>';
            reg = '<?php echo $registros; ?>';
            $("#Modal-IU").modal("show");
            $("#Data-IU").load("./views/categorias/formUpdateCategorias.php?idcategoria=" + idcategoria + "&num=" + num + "&num_reg=" + reg);
            document.getElementById("titulo-header-IU").innerText = "Actualizar Categoría";
            document.getElementById("btn-accion-IU").innerText = "Actualizar";
            return false;
        });


        /* Proceso de Insert ó Update Categoría */
        $("#Acciones-IU").click(function() {
            let accion = $("#accion").val();
            let idcategoria = $('[name="idcategoria"]').val();
            let categoria = $('[name="categoria"]').val();
            let estado = $('[name="estado"]').val();
            let num = $('[name="num"]').val();
            let num_reg = $('[name="num_reg"]').val();

            if (accion == "insert") {
                $.ajax({
                    url: "./views/categorias/insert.php",
                    type: "POST",
                    dataType: "html",
                    data: {
                        categoria: categoria
                    },
                    success: function(result) {
                        $("#Modal-IU").modal("hide");
                        $("#DataPanelCategorias").html(result);
                    }
                });
            } else {
                $.ajax({
                    url: "./views/categorias/update.php",
                    type: "POST",
                    dataType: "html",
                    data: {
                        idcategoria: idcategoria,
                        categoria: categoria,
                        estado: estado,
                        num: num,
                        num_reg: num_reg
                    },
                    success: function(result) {
                        $("#Modal-IU").modal("hide");
                        $("#DataPanelCategorias").html(result);
                    }
                });
            }
            return false;
        });



        /* Eliminar Categoria */
        $(".BtnDelCategoria").click(function() {
            let idcategoria = $(this).attr("idcategoria");
            let valor = $(this).attr("valor");
            let num, reg;
            num = '<?php echo $pagina; ?>';
            reg = '<?php echo $registros; ?>';
            alertify.confirm('Categorías', 'Seguro/a de eliminar categoría ....', function() {
                $.ajax({
                    url: './views/categorias/del.php',
                    type: 'post',
                    data: {
                        idcategoria: idcategoria,
                        num: num,
                        num_reg: reg
                    },
                    success: function(response) {
                        $("#DataPanelCategorias").html(response);
                    }
                });
            }, function() {});

            return false;
        });
    });
</script>