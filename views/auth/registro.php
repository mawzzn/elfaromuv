<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ya está logueado
if(isset($_SESSION['id'])) {
    // Si ya está logueado, redirigir a la página principal
    header('Location: index.php');
    exit();
}

// Variables para mantener los valores del formulario en caso de error
$nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
$apellido = isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
?>

<!-- Formulario de registro -->
<section class="section">
  <div class="container">
    <div class="columns is-centered">
      <div class="column is-6">
        <!-- Mensajes de error -->
        <?php if(isset($_GET['error'])): ?>
          <div class="notification is-danger">
            <?php 
              $error = $_GET['error'];
              switch($error) {
                case 'email':
                  echo 'Este correo electrónico ya está registrado. Por favor, utiliza otro o inicia sesión.';
                  break;
                case 'password_mismatch':
                  echo 'Las contraseñas no coinciden. Por favor, inténtalo de nuevo.';
                  break;
                case 'general':
                  echo 'Ha ocurrido un error al procesar tu registro. Por favor, inténtalo de nuevo.';
                  break;
                default:
                  echo 'Ha ocurrido un error. Por favor, inténtalo de nuevo.';
              }
            ?>
          </div>
        <?php endif; ?>
        
        <div class="box">
          <h1 class="title is-3 has-text-centered mb-5">Crear cuenta</h1>
          
          <form action="index.php?controller=usuario&action=registrar" method="post">
            <div class="field">
              <label class="label">Nombre</label>
              <div class="control has-icons-left">
                <input class="input" type="text" name="nombre" value="<?php echo $nombre; ?>" placeholder="Tu nombre" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </div>
            </div>
            
            <div class="field">
              <label class="label">Apellido</label>
              <div class="control has-icons-left">
                <input class="input" type="text" name="apellido" value="<?php echo $apellido; ?>" placeholder="Tu apellido" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </div>
            </div>
            
            <div class="field">
              <label class="label">Correo electrónico</label>
              <div class="control has-icons-left">
                <input class="input" type="email" name="email" value="<?php echo $email; ?>" placeholder="Tu correo electrónico" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
              </div>
            </div>
            
            <div class="field">
              <label class="label">Contraseña</label>
              <div class="control has-icons-left">
                <input class="input" type="password" name="password" placeholder="Tu contraseña" minlength="6" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
                </span>
              </div>
              <p class="help">La contraseña debe tener al menos 6 caracteres</p>
            </div>
            
            <div class="field">
              <label class="label">Confirmar contraseña</label>
              <div class="control has-icons-left">
                <input class="input" type="password" name="confirm_password" placeholder="Confirma tu contraseña" minlength="6" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
                </span>
              </div>
            </div>
            
            <div class="field">
              <div class="control">
                <label class="checkbox">
                  <input type="checkbox" required>
                  Acepto los <a href="#">términos y condiciones</a> y la <a href="#">política de privacidad</a>
                </label>
              </div>
            </div>
            
            <div class="field">
              <div class="control">
                <button type="submit" name="registrar" class="button is-primary is-fullwidth">Registrarse</button>
              </div>
            </div>
          </form>
          
          <div class="has-text-centered mt-5">
            <p>¿Ya tienes una cuenta? <a href="index.php?controller=usuario&action=mostrarLogin">Iniciar sesión</a></p>
          </div>
        </div>
        
        <div class="box mt-5">
          <h3 class="title is-5">Beneficios de registrarte:</h3>
          <div class="content">
            <ul>
              <li><strong>Acceso a contenido exclusivo</strong> - Artículos y reportajes especiales solo para suscriptores.</li>
              <li><strong>Personalización</strong> - Recibe noticias adaptadas a tus intereses.</li>
              <li><strong>Participación</strong> - Comenta en los artículos y participa en nuestra comunidad.</li>
              <li><strong>Sin publicidad</strong> - Disfruta de una experiencia sin anuncios intrusivos.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>