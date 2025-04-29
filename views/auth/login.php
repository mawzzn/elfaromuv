
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
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
?>

<!-- Formulario de inicio de sesión -->
<section class="section">
  <div class="container">
    <div class="columns is-centered">
      <div class="column is-5">
        <!-- Mensajes de error específicos -->
        <?php if(isset($_GET['error'])): ?>
          <div class="notification is-danger">
            <?php 
              $error = $_GET['error'];
              switch($error) {
                case 'credenciales':
                  echo 'Email o contraseña incorrectos. Por favor, inténtalo de nuevo.';
                  break;
                case 'login_required':
                  echo 'Debes iniciar sesión para acceder a esta página.';
                  break;
                case 'sistema':
                  echo 'Ha ocurrido un error en el sistema. Por favor, inténtalo más tarde.';
                  break;
                default:
                  echo 'Ha ocurrido un error. Por favor, inténtalo de nuevo.';
              }
            ?>
          </div>
        <?php endif; ?>
        
        <!-- Mensaje de éxito después de registro -->
        <?php if(isset($_GET['success']) && $_GET['success'] == 'registro'): ?>
          <div class="notification is-success">
            Te has registrado correctamente. Ahora puedes iniciar sesión.
          </div>
        <?php endif; ?>
        
        <!-- Mensaje de cierre de sesión -->
        <?php if(isset($_GET['success']) && $_GET['success'] == 'logout'): ?>
          <div class="notification is-info">
            Has cerrado sesión correctamente.
          </div>
        <?php endif; ?>
        
        <div class="box">
          <h1 class="title is-3 has-text-centered mb-5">Iniciar sesión</h1>
          
          <form action="index.php?controller=usuario&action=login" method="post">
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
                <input class="input" type="password" name="password" placeholder="Tu contraseña" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
                </span>
              </div>
            </div>
            
            <div class="field">
              <div class="control">
                <label class="checkbox">
                  <input type="checkbox" name="remember">
                  Recordar sesión
                </label>
              </div>
            </div>
            
            <div class="field">
              <div class="control">
                <button type="submit" name="login" class="button is-primary is-fullwidth">Iniciar sesión</button>
              </div>
            </div>
            
            <div class="has-text-centered mt-4">
              <a href="index.php?controller=usuario&action=recuperarPassword">¿Olvidaste tu contraseña?</a>
            </div>
          </form>
          
          <div class="has-text-centered mt-5">
            <p>¿No tienes una cuenta? <a href="index.php?controller=usuario&action=mostrarRegistro">Regístrate ahora</a></p>
          </div>
          
          <div class="is-divider" data-content="O"></div>
          
          <div class="buttons is-centered">
            <button class="button is-info">
              <span class="icon">
                <i class="fab fa-facebook-f"></i>
              </span>
              <span>Facebook</span>
            </button>
            <button class="button is-danger">
              <span class="icon">
                <i class="fab fa-google"></i>
              </span>
              <span>Google</span>
            </button>
          </div>
        </div>
        
        <div class="notification is-info is-light mt-5">
          <div class="content">
            <p><strong>¿Problemas para iniciar sesión?</strong></p>
            <p>Si tienes dificultades para acceder a tu cuenta, por favor contacta con nuestro equipo de soporte en <a href="mailto:soporte@elfaro.com">soporte@elfaro.com</a> o llama al 123-456-789.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>