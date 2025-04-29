<?php
/**
 * Controlador para la página principal
 */
class HomeController {
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
     * Mostrar la página principal
     */
    public function index() {
        // Obtener artículos destacados
        $articulos_destacados = $this->articulo->leerDestacados();

        // Obtener artículos de noticias generales (categoría 1)
        $articulos_generales = $this->articulo->leerPorCategoria(1);

        // Obtener artículos de deportes (categoría 2)
        $articulos_deportes = $this->articulo->leerPorCategoria(2);

        // Obtener artículos de negocios (categoría 3)
        $articulos_negocios = $this->articulo->leerPorCategoria(3);

        // Obtener todas las categorías para el menú
        $categorias_stmt = $this->categoria->leerTodas();

        // Incluir las vistas
        include_once 'views/layouts/header.php';
        include_once 'views/home/index.php';
        include_once 'views/layouts/footer.php';
    }
}
?>