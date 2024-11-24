<?php
class GestionCRUD
{
    private $pdo;

    public function __construct()
    {
        // Crear una instancia de ConexionBD y obtener la conexión PDO
        $conexion = new ConexionBD();
        $this->pdo = $conexion->getConexion();
    }

    public function isdu($tabla, $campos, $val_cond,$campo, $valor, $accion)
    {
        try {
            // Preparar la llamada al procedimiento almacenado
            $stmt = $this->pdo->prepare("CALL CRUD(:tabla,:campos,:val_cond,:campo, :valor, :accion, @resultado)");
            // Vincular los parámetros
            $stmt->bindParam(':tabla', $tabla, PDO::PARAM_STR);
            $stmt->bindParam(':campos', $campos, PDO::PARAM_STR);
            $stmt->bindParam(':val_cond', $val_cond, PDO::PARAM_STR);
            $stmt->bindParam(':campo', $campo, PDO::PARAM_STR);
            $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
            $stmt->bindParam(':accion', $accion, PDO::PARAM_STR);
            // Ejecutar el procedimiento almacenado
            $stmt->execute();
            // Obtener el resultado de la variable de salida para INSERT, UPDATE, DELETE
            if ($accion == 'I'|| $accion == 'i'|| $accion == 'ISB' || $accion == 'isb' || $accion == 'U' || $accion == 'u' ||$accion == 'D' || $accion == 'd') {
                // Cerrar el cursor de la consulta anterior antes de ejecutar la nueva consulta
                $stmt->closeCursor();
                // Obtener el resultado de la variable de salida
                $result = $this->pdo->query("SELECT @resultado AS resultado")->fetch(PDO::FETCH_ASSOC);
                return $result['resultado'];
            }
            // Para SELECT
            elseif ($accion === 'S' || $accion === 'SC') {
                // Inicializar el array para almacenar los resultados
                $row = [];
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $row[] = $result;
                }
                return $row;
            }
        } catch (PDOException $e) {
            echo "Error al ejecutar el procedimiento: " . $e->getMessage();
            return false; // Retorna false en caso de error
        }
    }

    public function BuscaValor($tabla, $campo, $condicion){
        try {
            // Preparar la llamada a la función almacenada
            $stmt = $this->pdo->prepare("CALL ObtenerCampo(:tabla, :campo, :condicion, @resultado)");

            // Vincular los parámetros
            $stmt->bindParam(':tabla', $tabla, PDO::PARAM_STR);
            $stmt->bindParam(':campo', $campo, PDO::PARAM_STR);
            $stmt->bindParam(':condicion', $condicion, PDO::PARAM_STR);
            
            // Ejecutar el procedimiento almacenado
            $stmt->execute();
    
            // Obtener el resultado de la variable de salida
            $result = $this->pdo->query("SELECT @resultado AS resultado")->fetch(PDO::FETCH_ASSOC);
            return $result['resultado'];
        } catch (PDOException $e) {
            echo "Error al ejecutar el procedimiento: " . $e->getMessage();
            return false;
        }
    }

    public function contarRegistros($query)
    {
        try {
            // Preparar la llamada al procedimiento almacenado
            $stmt = $this->pdo->prepare("CALL ContarRegistros(:query, @resultado)");
            // Vincular los parámetros
            $stmt->bindParam(':query', $query, PDO::PARAM_STR);
            // Ejecutar el procedimiento almacenado
            $stmt->execute();
            // Obtener el valor de salida (@resultado)
            $resultadoQuery = $this->pdo->query("SELECT @resultado AS resultado");
            $resultado = $resultadoQuery->fetch(PDO::FETCH_ASSOC)['resultado'];
            // Retornar el resultado
            return $resultado;
        } catch (PDOException $e) {
            // Manejar errores
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function ObtenerUltimoID($tabla, $id)
    {
        try {
            // Preparar la llamada al procedimiento almacenado
            $stmt = $this->pdo->prepare("CALL ObtenerUltimoID(:tabla, :id, @ultimoID)");
            // Vincular el parámetro de la tabla
            $stmt->bindParam(':tabla', $tabla, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            // Ejecutar el procedimiento almacenado
            $stmt->execute();
            // Obtener el resultado de la variable de salida
            $result = $this->pdo->query("SELECT @ultimoID AS ultimoID")->fetch(PDO::FETCH_ASSOC);
            return $result['ultimoID'];
        } catch (PDOException $e) {
            echo "Error al ejecutar el procedimiento: " . $e->getMessage();
            return false;
        }
    }
    public function cerrarConexion()
    {
        $this->pdo = null;
    }
}
