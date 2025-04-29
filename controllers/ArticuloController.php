<?php
/**
 * Controlador para gestionar artículos
 */
class ArticuloController {
    private $db;
    private $articulo;
    private $categoria;

    /**
     * Constructor del controlador
     */
    public function __construct() {
        // Obtener conexión a la base de datos
        require_once 'config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();

        // Instanciar el modelo Articulo
        require_once 'models/Articulo.php';
        $this->articulo = new Articulo($this->db);

        // Instanciar el modelo Categoria
        require_once 'models/Categoria.php';
        $this->categoria = new Categoria($this->db);
    }

    /**
     * Listar artículos por categoría
     * @param int $id_categoria
     */
    public function listarPorCategoria($id_categoria = null) {
        // Si se recibe un ID de categoría
        if($id_categoria) {
            // Obtener artículos de esa categoría
            $stmt = $this->articulo->leerPorCategoria($id_categoria);
            
            // Obtener información de la categoría
            $this->categoria->id = $id_categoria;
            $this->categoria->leerUna();
            $nombre_categoria = $this->categoria->nombre;
        } else {
            // Obtener todos los artículos
            $stmt = $this->articulo->leerTodos();
            $nombre_categoria = "Todas las categorías";
        }

        // Obtener todas las categorías para el menú
        $categorias_stmt = $this->categoria->leerTodas();

        // Incluir las vistas
        include_once 'views/layouts/header.php';
        include_once 'views/articulos/lista.php';
        include_once 'views/layouts/footer.php';
    }

    /**
     * Mostrar detalle de un artículo
     * @param int $id_articulo
     */
    public function mostrarDetalle($id_articulo) {
        // Asignar ID al objeto artículo
        $this->articulo->id = $id_articulo;

        // Leer detalles del artículo
        if($this->articulo->leerUno()) {
            // Obtener todas las categorías para el menú
            $categorias_stmt = $this->categoria->leerTodas();

            // Incluir las vistas
            include_once 'views/layouts/header.php';
            include_once 'views/articulos/detalle.php';
            include_once 'views/layouts/footer.php';
        } else {
            // Artículo no encontrado, redirigir a página principal
            header('Location: index.php?error=articulo_no_encontrado');
        }
    }

    /**
     * Crear un nuevo artículo
     */
    public function crear() {
        // Verificar si se reciben datos
        if(isset($_POST['guardar_articulo'])) {
            // Asignar valores a las propiedades del objeto
            $this->articulo->titulo = $_POST['titulo'];
            $this->articulo->contenido = $_POST['contenido'];
            $this->articulo->id_categoria = $_POST['id_categoria'];
            $this->articulo->autor = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Admin';
            $this->articulo->etiquetas = $_POST['etiquetas'] ?? '';
            $this->articulo->destacado = isset($_POST['destacado']) ? 1 : 0;

            // Procesar imagen
            if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagen_tmp = $_FILES['imagen']['tmp_name'];
                $imagen_nombre = basename($_FILES['imagen']['name']);
                $imagen_extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);
                $imagen_nuevo_nombre = uniqid() . '.' . $imagen_extension;
                $imagen_destino = 'assets/media/' . $imagen_nuevo_nombre;
                
                // Mover imagen
                if(move_uploaded_file($imagen_tmp, $imagen_destino)) {
                    $this->articulo->imagen = $imagen_nuevo_nombre;
                } else {
                    $this->articulo->imagen = 'default.jpg';
                }
            } else {
                $this->articulo->imagen = 'default.jpg';
            }

            // Crear artículo
            if($this->articulo->crear()) {
                // Redirigir a página principal
                header('Location: index.php?success=articulo_creado');
            } else {
                // Redirigir con mensaje de error
                header('Location: index.php?error=articulo_no_creado');
            }
        } else {
            // Obtener todas las categorías para el formulario
            $categorias_stmt = $this->categoria->leerTodas();

            // Incluir las vistas
            include_once 'views/layouts/header.php';
            include_once 'views/articulos/crear.php';
            include_once 'views/layouts/footer.php';
        }
    }
}