<?php
class ConexionBD {
    private $pdo;
    private $dsn = 'mysql:host=localhost;dbname=kptura;charset=utf8';
    private $username = 'root';
    private $password = '';

    public function __construct() {
        try {
            // Crear una instancia de PDO
            $this->pdo = new PDO($this->dsn, $this->username, $this->password);
            // Establecer el modo de error de PDO para que lance excepciones
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo 'Conectado: ';
        } catch (PDOException $e) {
            echo 'Conexión fallida: ' . $e->getMessage();
        }
    }

    // Método para obtener la instancia de PDO
    public function getConexion() {
        return $this->pdo;
    }

    // Método para cerrar la conexión
    public function cerrarConexion() {
        $this->pdo = null;
    }
}
?>