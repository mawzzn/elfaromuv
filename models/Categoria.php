<?php
/**
 * Modelo para gestionar categorías
 */
class Categoria {
    // Conexión a la base de datos y nombre de la tabla
    private $conn;
    private $table_name = "categorias";

    // Propiedades del objeto
    public $id;
    public $nombre;
    public $descripcion;

    /**
     * Constructor con conexión a la base de datos
     * @param PDO $db
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Leer todas las categorías
     * @return PDOStatement
     */
    public function leerTodas() {
        // Consulta para leer todas las categorías
        $query = "SELECT id, nombre, descripcion
                FROM " . $this->table_name . "
                ORDER BY nombre";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Ejecutar consulta
        $stmt->execute();

        return $stmt;
    }

    /**
     * Leer una categoría específica
     * @return boolean
     */
    public function leerUna() {
        // Consulta para leer una categoría
        $query = "SELECT id, nombre, descripcion
                FROM " . $this->table_name . "
                WHERE id = ?
                LIMIT 0,1";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Vincular valores
        $stmt->bindParam(1, $this->id);

        // Ejecutar consulta
        $stmt->execute();

        // Verificar si se encontró la categoría
        if($stmt->rowCount() > 0) {
            // Obtener fila
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Asignar valores
            $this->nombre = $row['nombre'];
            $this->descripcion = $row['descripcion'];

            return true;
        }

        return false;
    }

    /**
     * Crear una categoría
     * @return boolean
     */
    public function crear() {
        // Consulta para insertar un nuevo registro
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    nombre = :nombre,
                    descripcion = :descripcion";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Sanear datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        // Vincular valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);

        // Ejecutar consulta
        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>