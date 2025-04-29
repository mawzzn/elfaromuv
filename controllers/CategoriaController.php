<?php
/**
 * Controlador para gestionar categorías
 */
class CategoriaController {
    private $db;
    private $categoria;

    /**
     * Constructor del controlador
     */
    public function __construct() {
        // Obtener conexión a la base de datos
        require_once 'config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();

        // Instanciar el modelo Categoria
        require_once 'models/Categoria.php';
        $this->categoria = new Categoria($this->db);
    }

    /**
     * Listar todas las categorías
     */
    public function listar() {
        // Obtener todas las categorías
        $stmt = $this->categoria->leerTodas();

        // Incluir las vistas
        include_once 'views/layouts/header.php';
        include_once 'views/categorias/lista.php';
        include_once 'views/layouts/footer.php';
    }

    /**
     * Crear una nueva categoría
     */
    public function crear() {
        // Verificar si se reciben datos
        if(isset($_POST['guardar_categoria'])) {
            // Asignar valores a las propiedades del objeto
            $this->categoria->nombre = $_POST['nombre'];
            $this->categoria->descripcion = $_POST['descripcion'];

            // Crear categoría
            if($this->categoria->crear()) {
                // Redirigir a lista de categorías
                header('Location: index.php?controller=categoria&action=listar&success=categoria_creada');
            } else {
                // Redirigir con mensaje de error
                header('Location: index.php?controller=categoria&action=crear&error=categoria_no_creada');
            }
        } else {
            // Incluir las vistas
            include_once 'views/layouts/header.php';
            include_once 'views/categorias/crear.php';
            include_once 'views/layouts/footer.php';
        }
    }
}
?>