<?php
/**
 * Configuración de la conexión a la base de datos
 */
class Database {
    private $host = 'localhost';
    private $db_name = 'elfaro_db';
    private $username = 'root';
    private $password = '';
    private $conn;

    /**
     * Obtener la conexión a la base de datos
     * @return PDO
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>