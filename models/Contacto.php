<?php
/**
 * Modelo para gestionar mensajes de contacto
 */
class Contacto {
    // Conexión a la base de datos y nombre de la tabla
    private $conn;
    private $table_name = "contactos";

    // Propiedades del objeto
    public $id;
    public $nombre;
    public $email;
    public $asunto;
    public $mensaje;
    public $fecha;

    /**
     * Constructor con conexión a la base de datos
     * @param PDO $db
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Crear un mensaje de contacto
     * @return boolean
     */
    public function crear() {
        // Consulta para insertar un nuevo registro
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    nombre = :nombre,
                    email = :email,
                    asunto = :asunto,
                    mensaje = :mensaje,
                    fecha = NOW()";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Sanear datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->asunto = htmlspecialchars(strip_tags($this->asunto));
        $this->mensaje = htmlspecialchars(strip_tags($this->mensaje));

        // Vincular valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":asunto", $this->asunto);
        $stmt->bindParam(":mensaje", $this->mensaje);

        // Ejecutar consulta
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Leer todos los mensajes de contacto
     * @return PDOStatement
     */
    public function leerTodos() {
        // Consulta para leer todos los mensajes
        $query = "SELECT id, nombre, email, asunto, mensaje, fecha
                FROM " . $this->table_name . "
                ORDER BY fecha DESC";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Ejecutar consulta
        $stmt->execute();

        return $stmt;
    }
}
?>