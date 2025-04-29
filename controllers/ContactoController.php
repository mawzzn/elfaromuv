<?php
/**
 * Controlador para gestionar mensajes de contacto
 */
class ContactoController {
    private $db;
    private $contacto;
    private $categoria;

    /**
     * Constructor del controlador
     */
    public function __construct() {
        // Obtener conexión a la base de datos
        require_once 'config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();

        // Instanciar el modelo Contacto
        require_once 'models/Contacto.php';
        $this->contacto = new Contacto($this->db);

        // Instanciar el modelo Categoria para el menú
        require_once 'models/Categoria.php';
        $this->categoria = new Categoria($this->db);
    }

    /**
     * Mostrar formulario de contacto
     */
    public function mostrarFormulario() {
        // Obtener todas las categorías para el menú
        $categorias_stmt = $this->categoria->leerTodas();

        // Incluir las vistas
        include_once 'views/layouts/header.php';
        include_once 'views/contacto/formulario.php';
        include_once 'views/layouts/footer.php';
    }

    /**
     * Procesar formulario de contacto
     */
    public function enviar() {
        // Verificar si se reciben datos
        if(isset($_POST['enviar_contacto'])) {
            // Asignar valores a las propiedades del objeto
            $this->contacto->nombre = $_POST['nombre'];
            $this->contacto->email = $_POST['email'];
            $this->contacto->asunto = $_POST['asunto'];
            $this->contacto->mensaje = $_POST['mensaje'];

            // Crear mensaje de contacto
            if($this->contacto->crear()) {
                // Redirigir con mensaje de éxito
                header('Location: index.php?controller=contacto&action=mostrarFormulario&success=mensaje_enviado');
            } else {
                // Redirigir con mensaje de error
                header('Location: index.php?controller=contacto&action=mostrarFormulario&error=mensaje_no_enviado');
            }
        } else {
            // Redirigir al formulario
            header('Location: index.php?controller=contacto&action=mostrarFormulario');
        }
    }
}
?>