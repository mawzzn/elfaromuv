<?php
/**
 * Controlador para gestionar usuarios
 */
class UsuarioController {
    private $db;
    private $usuario;

    /**
     * Constructor del controlador
     */
    public function __construct() {
        // Obtener conexión a la base de datos
        require_once 'config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();

        // Instanciar el modelo Usuario
        require_once 'models/Usuario.php';
        $this->usuario = new Usuario($this->db);
    }

    /**
     * Mostrar formulario de registro
     */
    public function mostrarRegistro() {
        include_once 'views/layouts/header.php';
        include_once 'views/auth/registro.php';
        include_once 'views/layouts/footer.php';
    }

    /**
     * Procesar formulario de registro
     */
    public function registrar() {
        // Verificar si se reciben datos
        if(isset($_POST['registrar'])) {
            // Validar que las contraseñas coincidan
            if($_POST['password'] !== $_POST['confirm_password']) {
                // Redirigir con mensaje de error
                header('Location: index.php?controller=usuario&action=mostrarRegistro&error=password_mismatch');
                exit();
            }
            
            // Asignar valores a las propiedades del objeto
            $this->usuario->nombre = $_POST['nombre'];
            $this->usuario->apellido = $_POST['apellido'];
            $this->usuario->email = $_POST['email'];
            $this->usuario->password = $_POST['password'];
            $this->usuario->tipo_suscripcion = 'gratuito'; // Por defecto
            $this->usuario->activo = 1; // Activo por defecto

            // Verificar si el email ya existe
            if($this->usuario->emailExiste()) {
                // Redirigir con mensaje de error
                header('Location: index.php?controller=usuario&action=mostrarRegistro&error=email');
                exit();
            }

            // Crear usuario
            if($this->usuario->registrar()) {
                // Iniciar sesión automáticamente
                $_SESSION['id'] = $this->db->lastInsertId();
                $_SESSION['nombre'] = $this->usuario->nombre . ' ' . $this->usuario->apellido;
                $_SESSION['email'] = $this->usuario->email;
                $_SESSION['tipo_suscripcion'] = $this->usuario->tipo_suscripcion;

                // Redirigir a página principal
                header('Location: index.php?success=registro');
                exit();
            } else {
                // Redirigir con mensaje de error
                header('Location: index.php?controller=usuario&action=mostrarRegistro&error=general');
                exit();
            }
        } else {
            // Si no hay datos POST, mostrar formulario
            $this->mostrarRegistro();
        }
    }

    /**
     * Mostrar formulario de inicio de sesión
     */
    public function mostrarLogin() {
        include_once 'views/layouts/header.php';
        include_once 'views/auth/login.php';
        include_once 'views/layouts/footer.php';
    }

    /**
     * Procesar formulario de inicio de sesión
     */
    public function login() {
        // Verificar si se reciben datos
        if(isset($_POST['login'])) {
            try {
                // Asignar valores a las propiedades del objeto
                $this->usuario->email = $_POST['email'];
                $this->usuario->password = $_POST['password'];

                // Validar inicio de sesión
                if($this->usuario->login()) {
                    // Iniciar sesión
                    session_start();
                    $_SESSION['id'] = $this->usuario->id;
                    $_SESSION['nombre'] = $this->usuario->nombre . ' ' . $this->usuario->apellido;
                    $_SESSION['email'] = $this->usuario->email;

                    // Actualizar último acceso (opcional)
                    $query = "UPDATE usuarios SET ultimo_login = NOW() WHERE id = :id";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':id', $this->usuario->id);
                    $stmt->execute();

                    // Redirigir a página principal
                    header('Location: index.php?success=login');
                    exit();
                } else {
                    // Redirigir con mensaje de error
                    header('Location: index.php?controller=usuario&action=mostrarLogin&error=credenciales');
                    exit();
                }
            } catch (Exception $e) {
                // Registrar error
                error_log("Error en login: " . $e->getMessage());
                
                // Redirigir con mensaje de error
                header('Location: index.php?controller=usuario&action=mostrarLogin&error=sistema');
                exit();
            }
        } else {
            // Si no hay datos POST, mostrar formulario
            $this->mostrarLogin();
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Eliminar todas las variables de sesión
        $_SESSION = array();

        // Destruir la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destruir la sesión
        session_destroy();

        // Redirigir a página principal
        header('Location: index.php?success=logout');
        exit();
    }

    /**
     * Mostrar perfil de usuario
     */
    public function perfil() {
        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?controller=usuario&action=mostrarLogin&error=login_required');
            exit();
        }

        // Obtener datos del usuario
        $this->usuario->id = $_SESSION['id'];
        $this->usuario->leerUno();

        // Mostrar vista de perfil
        include_once 'views/layouts/header.php';
        include_once 'views/auth/perfil.php';
        include_once 'views/layouts/footer.php';
    }

    /**
     * Actualizar datos de perfil
     */
    public function actualizarPerfil() {
        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?controller=usuario&action=mostrarLogin&error=login_required');
            exit();
        }

        // Verificar si se reciben datos
        if(isset($_POST['actualizar_perfil'])) {
            // Asignar valores
            $this->usuario->id = $_SESSION['id'];
            $this->usuario->nombre = $_POST['nombre'];
            $this->usuario->apellido = $_POST['apellido'];
            $this->usuario->email = $_POST['email'];
            $this->usuario->tipo_suscripcion = $_SESSION['tipo_suscripcion']; // Mantener el mismo tipo
            $this->usuario->activo = 1;

            // Actualizar perfil
            if($this->usuario->actualizar()) {
                // Actualizar datos de sesión
                $_SESSION['nombre'] = $this->usuario->nombre . ' ' . $this->usuario->apellido;
                $_SESSION['email'] = $this->usuario->email;

                // Redirigir a perfil
                header('Location: index.php?controller=usuario&action=perfil&success=actualizado');
                exit();
            } else {
                // Redirigir con error
                header('Location: index.php?controller=usuario&action=perfil&error=actualizacion');
                exit();
            }
        } else {
            // Redirigir a perfil
            header('Location: index.php?controller=usuario&action=perfil');
            exit();
        }
    }

    /**
     * Cambiar contraseña
     */
    public function cambiarPassword() {
        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?controller=usuario&action=mostrarLogin&error=login_required');
            exit();
        }

        // Verificar si se reciben datos
        if(isset($_POST['cambiar_password'])) {
            // Verificar que las contraseñas coincidan
            if($_POST['nueva_password'] !== $_POST['confirm_password']) {
                header('Location: index.php?controller=usuario&action=perfil&error=password_mismatch');
                exit();
            }

            // Cambiar contraseña
            $this->usuario->id = $_SESSION['id'];
            if($this->usuario->cambiarPassword($_POST['nueva_password'])) {
                header('Location: index.php?controller=usuario&action=perfil&success=password');
                exit();
            } else {
                header('Location: index.php?controller=usuario&action=perfil&error=password_change');
                exit();
            }
        } else {
            // Redirigir a perfil
            header('Location: index.php?controller=usuario&action=perfil');
            exit();
        }
    }
}
?>