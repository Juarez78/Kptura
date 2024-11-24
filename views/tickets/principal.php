<?php
session_start();
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';
$idusuario = $_SESSION['idusuario'];
$tipo = $_SESSION['tipo'];
if($tipo == 1 || $tipo == 2){
    $dataTickets = CRUD('ticket', '*', '', '', '', 'S') ;
}else{
    $dataTickets = CRUD('ticket', '*', 'idusuario="' . $idusuario . '"', '', '', 'SC') ;
}

$cont = 0;
?>
<div>
    <table class="table table-bordeless" style="margin: 0 auto; width: 80%;">
        <thead>
            <tr>
                <th class="centrar">Nº</th>
                <th class="centrar">Ticket</th>
                <th class="centrar">Productos</th>
                <th class="centrar">Estado</th>
                <th class="centrar">Fecha</th>
                <?php if($tipo != 3):?>
                    <th class="centrar">Ticket</th>
                <?php else:?>
                    <th class="centrar">Comprobante</th>
                <?php endif?>
            </tr>
        </thead>
        <tbody class="centrar">
            <?php foreach ($dataTickets as $result): ?>
                <tr>
                    <td  class="centrar"><?php echo $cont += 1; ?></td>
                    <td  class="centrar">
                        <?php
                        echo $idticket = $result['idticket'];
                        ?>
                    </td>
                    <td >
                        <?php
                        $idcarritos = $result['idcarrito'];
                        $idcarrito = explode(", ", $idcarritos);
                        for ($i = 0; count($idcarrito) > $i; $i++) {
                            $idproducto = buscavalor('carrito', 'idproducto', 'idcarrito="' . $idcarrito[$i] . '"')??[];
                            echo $producto = buscavalor('productos', 'nombre', 'idproducto="' . $idproducto . '"')??[] . '<br>';
                        }
                        ?>
                    </td>
                    <td  class="centrar">
                        <?php
                        echo $estado = $result['estado'];
                        ?>
                    </td>
                    <td  class="centrar">
                        <?php
                        echo $fecha = $result['fecha'];
                        ?>
                    </td>
                    <td  class="centrar">
                        <a class="btn btn-info btn-sm VerTicket" idticket="<?php echo $result['idticket']; ?>">
                            <i class="fa-solid fa-file-pdf"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function(){
        $(".VerTicket").click(function(){
            let idticket = $(this).attr('idticket');
            $("#Modal-IU").modal("show");
            $('#mimodal').addClass('modal-lg');
            $("#Data-IU").load("./views/tickets/data.php?idticket=" + idticket);
            // Obtener el elemento por su ID y cambiar el texto
            document.getElementById("titulo-header-IU").innerText = "Comprobante";
            document.getElementById("Acciones-IU").style.display = "none";
            return false;
        });
    });
</script>