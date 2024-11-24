<?php

function AccesoLogin($user, $passw, $tabla)
{   
    session_start();
    $consultas = new GestionCRUD();
    $data = $consultas->isdu($tabla, '*', 'usuario="' . $user . '"', '', '', 'SC');
    if ($data) {
        foreach ($data as $result) {
            $idusuario = $result['idusuario'];
            $clave = $result['clave'];
            $tipo = $result['tipo'];
            $estado = $result['estado'];
        }
        if ($estado == 1) {
            if (password_verify($passw, $clave)) {
                $_SESSION['login_ok'] = 1;
                $_SESSION['idusuario'] = $idusuario;
                $_SESSION['tipo'] = $tipo;
                echo '<script>
                        alertify.success("Bienvenido/a..");
                        setTimeout(function(){ window.location.href = "index.php";},500);
                    </script>';
            } else {
                echo '<script>
                        alertify.alert("Login","Contraseña incorrecta...");
                        setTimeout(function(){ window.location.href = "index.php";},1000);
                    </script>';
            }
        } else {
            echo '<script>
                alertify.alert("Login","El usuario no no tiene permisos de acceso...");
                setTimeout(function(){ window.location.href = "index.php";},1000);
            </script>';
        }
    } else {
        echo '<script>
            alertify.alert("Login","El usuario no existe..");
            setTimeout(function(){ window.location.href = "index.php";},1000);
        </script>';
    }
}

function CRUD($tabla, $campos, $val_cond, $campo, $valor, $accion)
{
    // Crear una instancia de GestionCRUD
    $proceso = new GestionCRUD();
    // Ejecutar el procedimiento almacenado usando el método isdu de GestionCRUD
    $resultados = $proceso->isdu($tabla, $campos, $val_cond, $campo, $valor, $accion);
    // Cerrar la conexión después de la operación
    $proceso->cerrarConexion();
    // Retornar los resultados
    return $resultados;
}

function buscavalor($tabla, $campo, $condicion)
{
    // Crear una instancia de GestionCRUD
    $proceso = new GestionCRUD();
    // Ejecutar el procedimiento almacenado usando el método isdu de GestionCRUD
    $resultados = $proceso->BuscaValor($tabla, $campo, $condicion);
    // Cerrar la conexión después de la operación
    $proceso->cerrarConexion();
    // Retornar los resultados
    return $resultados;
}

function CountReg($query)
{
    $proceso = new GestionCRUD();
    // Ejecutar el procedimiento almacenado usando el método isdu de GestionCRUD
    $resultados = $proceso->contarRegistros($query);
    // Cerrar la conexión después de la operación
    $proceso->cerrarConexion();
    // Retornar los resultados
    return $resultados;
}

function subirImagen($archivo, $rutaDestino, $idRegistro) {
    // Definir los formatos permitidos
    $formatosPermitidos = ['png','jpg','jpeg','gif'];

    // Extraer información del archivo
    $tipoArchivo = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen
    $check = getimagesize($archivo['tmp_name']);
    if ($check === false) {
        return 2;
    }

    // Verificar el formato
    if (!in_array($tipoArchivo, $formatosPermitidos)) {
        return 4;
    }

    // Renombrar el archivo con el id del registro
    $nuevoNombreArchivo = $idRegistro . "." . $tipoArchivo;
    $rutaCompleta = $rutaDestino . $nuevoNombreArchivo;

    // Mover el archivo a la ruta destino
    if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
        chmod($rutaCompleta, 0777); 
        return 1;
    } else {
        return 0;
    }
}

function MaxID($tabla,$id)
{
    $proceso = new GestionCRUD();
    // Ejecutar el procedimiento almacenado usando el método isdu de GestionCRUD
    $resultados = $proceso->ObtenerUltimoID($tabla,$id);
    // Cerrar la conexión después de la operación
    $proceso->cerrarConexion();
    // Retornar los resultados
    return $resultados;
}
