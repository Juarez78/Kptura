<?php
session_start();
include '../../models/conexion.php';
include '../../models/funciones.php';
include '../../controllers/funciones.php';
date_default_timezone_set("America/El_Salvador");
$fecha_actual = date("Y-m-d H:i:s");
$idticket = $_GET['idticket'];
$tipo = $_SESSION['tipo'];
$idusuario = buscavalor('ticket', 'idusuario', 'idticket="' . $idticket . '"');
$cliente = buscavalor('clientes', 'CONCAT(nombre," ",apellido)', 'idusuario="' . $idusuario . '"');

if(buscavalor('ticket', 'estado', 'idticket="' . $idticket . '"') == 1){
    $estadoT = "Cancelado";
}else{
    $estadoT = "Pendiente";
}
$dataTickets = CRUD('ticket', '*', 'idticket="' . $idticket . '"', '', '', 'SC') ?? [];
$contTotal = 0;
$contCantidad = 0;
?>
<div id="muestra">
    <div class="centrar" style="margin-bottom: 10px;">
        <img src="./public/img/logo.png" width="150px" alt="">
    </div>
    <div class="row">
        <div class="col-md-6">
            <p><b>Comprobante Nº </b><?php echo $idticket; ?></p>
            <p><b>Cliente: </b><?php echo $cliente; ?></p>
            <p><b>Estado: </b><?php echo $estadoT; ?></p>
        </div>
        <div class="col-md-6" style="text-align: end;">
            <b>Fecha: </b><?php echo $fecha_actual; ?>
        </div>
    </div>
    <table class="table table-bordeless" style="margin: 0 auto; width: 100%;border-collapse: collapse;" border="1">
        <thead>
            <tr>
                <th class="centrar">Nº</th>
                <th class="centrar">Productos</th>
                <th class="centrar">Cantidad</th>
                <th class="centrar">Total</th>
            </tr>
        </thead>
        <tbody class="centrar">
            <?php foreach ($dataTickets as $result): ?>
                <tr>
                    <td class="centrar">
                        <?php 
                        $idcarritos = $result['idcarrito'];
                        $idcarrito = explode(", ", $idcarritos);
                        for ($i = 1; count($idcarrito) >= $i; $i++) {
                            echo $i."<br>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        for ($i = 0; count($idcarrito) <= $i; $i++) {
                            $idproducto = buscavalor('carrito', 'idproducto', 'idcarrito="' . $idcarrito[$i] . '"');
                            echo $producto = buscavalor('productos', 'nombre', 'idproducto="' . $idproducto . '"') . '<br>';
                        }
                        ?>
                    </td>
                    <td class="centrar">
                        <?php
                        for ($i = 0; count($idcarrito) <= $i; $i++) {
                            echo $cantidad = buscavalor('carrito', 'cantidad', 'idcarrito="' . $idcarrito[$i] . '"') . '<br>';
                            $cantidadF = buscavalor('carrito', 'cantidad', 'idcarrito="' . $idcarrito[$i] . '"');
                            $contCantidad += $cantidadF;
                        }

                        ?>
                    </td>
                    <td class="centrar">$
                        <?php
                        for ($i = 0; count($idcarrito) <= $i; $i++) {
                            echo $total = buscavalor('carrito', 'total', 'idcarrito="' . $idcarrito[$i] . '"') . '<br>';
                            $totalF = buscavalor('carrito', 'total', 'idcarrito="' . $idcarrito[$i] . '"');
                            $contTotal += $totalF;
                        }

                        ?>
                    </td>
                </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="2" class="centrar"><b>Total</b></td>
                <td>
                    <?php echo $contCantidad; ?>
                </td>
                <td>
                    $ <?php echo number_format($contTotal, 2); ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<button type="button" class="btn btn-primary" onclick="javascript:imprim2();">
    <i class="fa-solid fa-print"></i>
</button>
<script>
    function imprim2() {
        var titulo = "Comprobante Pedido";
        var mywindow = window.open('', 'PRINT', 'height=600,width=800');
        mywindow.document.write('<html><head><title>' + titulo + '</title>');
        mywindow.document.write('<style>body{margin: 20mm 25mm 20mm 25mm; font-size:14px;font-family: "Roboto Condensed", sans-serif !important;} table {border-collapse: collapse;font-size:14px;} @media print {.show_div {display: block !important;} .centrar {text-align: center;vertical-align: middle;}</style>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById('muestra').innerHTML);
        mywindow.document.write('</body></html>');
        mywindow.document.close(); // necesario para IE >= 10
        mywindow.focus(); // necesario para IE >= 10
        mywindow.print();
        mywindow.close();

        return true;
    }
</script>