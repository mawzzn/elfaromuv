<?php
/**
 * Modelo para gestionar usuarios
 */
class Usuario {
    // Conexión a la base de datos y nombre de la tabla
    private $conn;
    private $table_name = "usuarios";

    // Propiedades del objeto
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $fecha_registro;
    public $tipo_suscripcion;
    public $activo;

    /**
     * Constructor con conexión a la base de datos
     * @param PDO $db
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Registrar un nuevo usuario
     * @return boolean
     */
    public function registrar() {
        // Consulta para insertar un nuevo registro
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    nombre = :nombre,
                    apellido = :apellido,
                    email = :email,
                    password = :password,
                    fecha_registro = NOW(),
                    tipo_suscripcion = :tipo_suscripcion,
                    activo = :activo";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Sanear datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->email = htmlspecialchars(strip_tags($this->email));
        
        // Hash de la contraseña
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

        // Vincular valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":tipo_suscripcion", $this->tipo_suscripcion);
        $stmt->bindParam(":activo", $this->activo);

        // Ejecutar consulta
        if($stmt->execute()) {
            return true;
        }

        return false;
    }
    
    /**
     * Iniciar sesión de usuario
     * @return boolean
     */
    public function login() {
        try {
            // Guardar la contraseña ingresada
            $password_ingresado = $this->password;
            
            // Consulta para verificar credenciales
            $query = "SELECT id, nombre, apellido, email, password 
                      FROM " . $this->table_name . " 
                      WHERE email = :email 
                      LIMIT 1";
            
            // Preparar consulta
            $stmt = $this->conn->prepare($query);
            
            // Sanear datos
            $this->email = htmlspecialchars(strip_tags($this->email));
            
            // Vincular parámetros
            $stmt->bindParam(':email', $this->email);
            
            // Ejecutar consulta
            $stmt->execute();
            
            // Verificar si se encontró el usuario
            if($stmt->rowCount() > 0) {
                // Obtener datos del usuario
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Asignar valores a propiedades del objeto
                $this->id = $row['id'];
                $this->nombre = $row['nombre'];
                $this->apellido = $row['apellido'];
                $this->email = $row['email'];
                $password_hash = $row['password'];
                
                // Verificar contraseña
                if(password_verify($password_ingresado, $password_hash)) {
                    // Contraseña correcta
                    return true;
                }
            }
            
            // Email no encontrado o contraseña incorrecta
            return false;
            
        } catch(PDOException $e) {
            // Registrar error (en un entorno de producción)
            error_log("Error de login: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si existe un email en la base de datos
     * @return boolean
     */
    public function emailExiste() {
        // Consulta para comprobar si el email existe
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE email = :email 
                  LIMIT 1";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Sanear email
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Vincular valores
        $stmt->bindParam(':email', $this->email);

        // Ejecutar consulta
        $stmt->execute();

        // Verificar si existe el email
        return ($stmt->rowCount() > 0);
    }

    /**
     * Obtener datos del usuario por ID
     * @return boolean
     */
    public function leerUno() {
        // Consulta para leer un usuario
        $query = "SELECT id, nombre, apellido, email, fecha_registro, tipo_suscripcion, activo 
                  FROM " . $this->table_name . " 
                  WHERE id = :id 
                  LIMIT 1";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Sanear ID
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular parámetros
        $stmt->bindParam(':id', $this->id);

        // Ejecutar consulta
        $stmt->execute();

        // Verificar si se encontró el usuario
        if($stmt->rowCount() > 0) {
            // Obtener datos
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Asignar valores a propiedades
            $this->nombre = $row['nombre'];
            $this->apellido = $row['apellido'];
            $this->email = $row['email'];
            $this->fecha_registro = $row['fecha_registro'];
            $this->tipo_suscripcion = $row['tipo_suscripcion'];
            $this->activo = $row['activo'];
            
            return true;
        }
        
        return false;
    }

    /**
     * Actualizar datos del usuario
     * @return boolean
     */
    public function actualizar() {
        // Consulta para actualizar registro
        $query = "UPDATE " . $this->table_name . "
                SET
                    nombre = :nombre,
                    apellido = :apellido,
                    email = :email,
                    tipo_suscripcion = :tipo_suscripcion,
                    activo = :activo
                WHERE id = :id";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Sanear datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->tipo_suscripcion = htmlspecialchars(strip_tags($this->tipo_suscripcion));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":tipo_suscripcion", $this->tipo_suscripcion);
        $stmt->bindParam(":activo", $this->activo);
        $stmt->bindParam(":id", $this->id);

        // Ejecutar consulta
        return $stmt->execute();
    }
    
    /**
     * Actualizar contraseña del usuario
     * @param string $nueva_password Nueva contraseña
     * @return boolean
     */
    public function cambiarPassword($nueva_password) {
        // Consulta para actualizar contraseña
        $query = "UPDATE " . $this->table_name . "
                SET password = :password
                WHERE id = :id";

        // Preparar consulta
        $stmt = $this->conn->prepare($query);

        // Hash de la nueva contraseña
        $password_hash = password_hash($nueva_password, PASSWORD_BCRYPT);
        
        // Sanear ID
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":id", $this->id);

        // Ejecutar consulta
        return $stmt->execute();
    }
}
?>