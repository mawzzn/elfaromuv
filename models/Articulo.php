<?php
/**
 * Modelo para gestionar artículos
 */
class Articulo {
    // Conexión a la base de datos y nombre de la tabla
    private $conn;
    private $table_name = "articulos";

    // Propiedades del objeto
    public $id;
    public $titulo;
    public $contenido;
    public $imagen;
    public $id_categoria;
    public $categoria_nombre;
    public $fecha_publicacion;
    public $etiquetas;
    public $autor;
    public $destacado;

    /**
     * Constructor con conexión a la base de datos
     * @param PDO $db
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Leer todos los artículos
     * @return PDOStatement
     */
    public function leerTodos() {
        // Consulta para leer todos los artículos
        $query = "SELECT a.id, a.titulo, a.contenido, a.imagen, a.fecha_publicacion, a.etiquetas, a.autor, a.destacado,
                    c.nombre as categoria_nombre
                FROM " . $this->table_name . " a
                LEFT JOIN categorias c ON a.id_categoria = c.id
                ORDER BY a.fecha_publicacion DESC";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Ejecutar consulta
        $stmt->execute();

        return $stmt;
    }

    /**
     * Leer un artículo específico
     * @return boolean
     */
    public function leerUno() {
        // Consulta para leer un artículo
        $query = "SELECT a.id, a.titulo, a.contenido, a.imagen, a.fecha_publicacion, a.etiquetas, a.autor, a.destacado,
                    c.nombre as categoria_nombre
                FROM " . $this->table_name . " a
                LEFT JOIN categorias c ON a.id_categoria = c.id
                WHERE a.id = ?
                LIMIT 0,1";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Vincular valores
        $stmt->bindParam(1, $this->id);

        // Ejecutar consulta
        $stmt->execute();

        // Verificar si se encontró el artículo
        if($stmt->rowCount() > 0) {
            // Obtener fila
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Asignar valores
            $this->titulo = $row['titulo'];
            $this->contenido = $row['contenido'];
            $this->imagen = $row['imagen'];
            $this->fecha_publicacion = $row['fecha_publicacion'];
            $this->etiquetas = $row['etiquetas'];
            $this->autor = $row['autor'];
            $this->destacado = $row['destacado'];
            $this->categoria_nombre = $row['categoria_nombre'];

            return true;
        }

        return false;
    }

    /**
     * Leer artículos por categoría
     * @param int $id_categoria
     * @return PDOStatement
     */
    public function leerPorCategoria($id_categoria) {
        // Consulta para leer artículos por categoría
        $query = "SELECT a.id, a.titulo, a.contenido, a.imagen, a.fecha_publicacion, a.etiquetas, a.autor, a.destacado,
                    c.nombre as categoria_nombre
                FROM " . $this->table_name . " a
                LEFT JOIN categorias c ON a.id_categoria = c.id
                WHERE a.id_categoria = ?
                ORDER BY a.fecha_publicacion DESC";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Vincular valores
        $stmt->bindParam(1, $id_categoria);

        // Ejecutar consulta
        $stmt->execute();

        return $stmt;
    }

    /**
     * Leer artículos destacados
     * @return PDOStatement
     */
    public function leerDestacados() {
        // Consulta para leer artículos destacados
        $query = "SELECT a.id, a.titulo, a.contenido, a.imagen, a.fecha_publicacion, a.etiquetas, a.autor, a.destacado,
                    c.nombre as categoria_nombre
                FROM " . $this->table_name . " a
                LEFT JOIN categorias c ON a.id_categoria = c.id
                WHERE a.destacado = 1
                ORDER BY a.fecha_publicacion DESC
                LIMIT 3";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Ejecutar consulta
        $stmt->execute();

        return $stmt;
    }

    /**
     * Crear un artículo
     * @return boolean
     */
    public function crear() {
        // Consulta para insertar un nuevo registro
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    titulo = :titulo,
                    contenido = :contenido,
                    imagen = :imagen,
                    id_categoria = :id_categoria,
                    fecha_publicacion = NOW(),
                    etiquetas = :etiquetas,
                    autor = :autor,
                    destacado = :destacado";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Sanear datos
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->contenido = htmlspecialchars(strip_tags($this->contenido));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $this->etiquetas = htmlspecialchars(strip_tags($this->etiquetas));
        $this->autor = htmlspecialchars(strip_tags($this->autor));
        $this->destacado = htmlspecialchars(strip_tags($this->destacado));

        // Vincular valores
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":contenido", $this->contenido);
        $stmt->bindParam(":imagen", $this->imagen);
        $stmt->bindParam(":id_categoria", $this->id_categoria);
        $stmt->bindParam(":etiquetas", $this->etiquetas);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":destacado", $this->destacado);

        // Ejecutar consulta
        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>