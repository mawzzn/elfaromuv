
<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    // Si no está logueado, redirigir a login
    header('Location: index.php?controller=usuario&action=mostrarLogin&error=login_required');
    exit();
}

// Verificar que tenemos acceso a los datos del usuario
if (!isset($this->usuario) || !isset($this->usuario->id)) {
    echo '<div class="notification is-danger">Error: No se pudieron cargar los datos del usuario.</div>';
    exit();
}
?>

<!-- Perfil de usuario -->
<section class="section">
  <div class="container">
    <div class="columns">
      <div class="column is-3">
        <!-- Panel lateral de navegación -->
        <div class="box">
          <aside class="menu">
            <p class="menu-label">Mi cuenta</p>
            <ul class="menu-list">
              <li><a class="is-active" href="index.php?controller=usuario&action=perfil">Perfil</a></li>
              <li><a href="#cambiar-password">Cambiar contraseña</a></li>
              <li><a href="#mis-suscripciones">Mis suscripciones</a></li>
              <li><a href="index.php?controller=usuario&action=logout">Cerrar sesión</a></li>
            </ul>
            <p class="menu-label">Contenido</p>
            <ul class="menu-list">
              <li><a href="index.php?controller=articulo&action=misArticulos">Mis artículos</a></li>
              <li><a href="index.php?controller=articulo&action=misComentarios">Mis comentarios</a></li>
              <li><a href="index.php?controller=articulo&action=misGuardados">Artículos guardados</a></li>
            </ul>
          </aside>
        </div>
      </div>
      
      <div class="column is-9">
        <!-- Mensajes de éxito o error -->
        <?php if(isset($_GET['success'])): ?>
          <div class="notification is-success">
            <?php 
              $success = $_GET['success'];
              switch($success) {
                case 'actualizado':
                  echo 'Tu perfil ha sido actualizado correctamente.';
                  break;
                case 'password':
                  echo 'Tu contraseña ha sido cambiada correctamente.';
                  break;
                default:
                  echo 'Operación realizada con éxito.';
              }
            ?>
          </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['error'])): ?>
          <div class="notification is-danger">
            <?php 
              $error = $_GET['error'];
              switch($error) {
                case 'actualizacion':
                  echo 'Ha ocurrido un error al actualizar tu perfil.';
                  break;
                case 'password_mismatch':
                  echo 'Las contraseñas no coinciden.';
                  break;
                case 'password_change':
                  echo 'Ha ocurrido un error al cambiar tu contraseña.';
                  break;
                default:
                  echo 'Ha ocurrido un error.';
              }
            ?>
          </div>
        <?php endif; ?>
        
        <!-- Información general del perfil -->
        <div class="box">
          <div class="level">
            <div class="level-left">
              <div class="level-item">
                <h1 class="title is-4">Mi perfil</h1>
              </div>
            </div>
            <div class="level-right">
              <div class="level-item">
                <div class="tags has-addons">
                  <span class="tag is-dark">Tipo de cuenta</span>
                  <span class="tag is-primary"><?php echo ucfirst($this->usuario->tipo_suscripcion); ?></span>
                </div>
              </div>
            </div>
          </div>
          
          <div class="columns is-vcentered mb-5">
           
            <div class="column">
              <h2 class="title is-4 mb-1"><?php echo $this->usuario->nombre . ' ' . $this->usuario->apellido; ?></h2>
              <p class="subtitle is-6 has-text-grey">Miembro desde <?php echo date('d/m/Y', strtotime($this->usuario->fecha_registro)); ?></p>
            </div>
            
          </div>
          
          <!-- Formulario de edición de perfil -->
          <form action="index.php?controller=usuario&action=actualizarPerfil" method="post">
            <div class="field is-horizontal">
              <div class="field-label is-normal">
                <label class="label">Nombre</label>
              </div>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input class="input" type="text" name="nombre" value="<?php echo $this->usuario->nombre; ?>" required>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="field is-horizontal">
              <div class="field-label is-normal">
                <label class="label">Apellido</label>
              </div>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input class="input" type="text" name="apellido" value="<?php echo $this->usuario->apellido; ?>" required>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="field is-horizontal">
              <div class="field-label is-normal">
                <label class="label">Email</label>
              </div>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input class="input" type="email" name="email" value="<?php echo $this->usuario->email; ?>" required>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="field is-horizontal">
              <div class="field-label">
                <!-- Espacio vacío para alineación -->
              </div>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <button type="submit" name="actualizar_perfil" class="button is-primary">
                      <span class="icon is-small">
                        <i class="fas fa-save"></i>
                      </span>
                      <span>Guardar cambios</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        
        <!-- Cambiar contraseña -->
        <div id="cambiar-password" class="box">
          <h3 class="title is-5 mb-4">Cambiar contraseña</h3>
          
          <form action="index.php?controller=usuario&action=cambiarPassword" method="post">
            <div class="field">
              <label class="label">Nueva contraseña</label>
              <div class="control has-icons-left">
                <input class="input" type="password" name="nueva_password" placeholder="Nueva contraseña" minlength="6" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
                </span>
              </div>
              <p class="help">La contraseña debe tener al menos 6 caracteres</p>
            </div>
            
            <div class="field">
              <label class="label">Confirmar contraseña</label>
              <div class="control has-icons-left">
                <input class="input" type="password" name="confirm_password" placeholder="Confirmar contraseña" minlength="6" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
                </span>
              </div>
            </div>
            
            <div class="field">
              <div class="control">
                <button type="submit" name="cambiar_password" class="button is-info">
                  <span class="icon is-small">
                    <i class="fas fa-key"></i>
                  </span>
                  <span>Cambiar contraseña</span>
                </button>
              </div>
            </div>
          </form>
        </div>
        
        <!-- Suscripciones -->
        <div id="mis-suscripciones" class="box">
          <h3 class="title is-5 mb-4">Mi suscripción</h3>
          
          <div class="columns">
            <div class="column is-8">
              <div class="content">
                <p><strong>Plan actual:</strong> <?php echo ucfirst($this->usuario->tipo_suscripcion); ?></p>
                <p><strong>Estado:</strong> <span class="tag is-success">Activa</span></p>
                
                <?php if($this->usuario->tipo_suscripcion === 'gratuito'): ?>
                  <div class="notification is-info is-light">
                    <p>Actualmente estás utilizando la versión gratuita. Actualiza a un plan premium para acceder a contenido exclusivo y disfrutar de una experiencia sin publicidad.</p>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <div class="column is-4">
              <?php if($this->usuario->tipo_suscripcion === 'gratuito'): ?>
                <button class="button is-primary is-fullwidth">
                  <span class="icon">
                    <i class="fas fa-arrow-up"></i>
                  </span>
                  <span>Actualizar a Premium</span>
                </button>
              <?php else: ?>
                <button class="button is-danger is-outlined is-fullwidth">
                  <span class="icon">
                    <i class="fas fa-times"></i>
                  </span>
                  <span>Cancelar suscripción</span>
                </button>
              <?php endif; ?>
            </div>
          </div>
          
          <?php if($this->usuario->tipo_suscripcion === 'gratuito'): ?>
            <div class="box has-background-light mt-4">
              <h4 class="title is-6 mb-3">Planes disponibles</h4>
              
              <div class="columns">
                <div class="column is-4">
                  <div class="card">
                    <div class="card-content">
                      <p class="title is-4">Básico</p>
                      <p class="subtitle has-text-primary is-4">$5.99<span class="is-size-6">/mes</span></p>
                      <div class="content">
                        <ul>
                          <li>Acceso a todos los artículos</li>
                          <li>Sin publicidad</li>
                          <li>Guardar artículos favoritos</li>
                        </ul>
                      </div>
                    </div>
                    <footer class="card-footer">
                      <a href="#" class="card-footer-item button is-primary is-light">Elegir</a>
                    </footer>
                  </div>
                </div>
                
                <div class="column is-4">
                  <div class="card">
                    <div class="card-content has-background-primary-light">
                      <p class="title is-4">Premium</p>
                      <p class="subtitle has-text-primary is-4">$9.99<span class="is-size-6">/mes</span></p>
                      <div class="content">
                        <ul>
                          <li>Todo lo del plan Básico</li>
                          <li>Contenido exclusivo</li>
                          <li>Acceso prioritario a eventos</li>
                          <li>Newsletters especiales</li>
                        </ul>
                      </div>
                    </div>
                    <footer class="card-footer">
                      <a href="#" class="card-footer-item button is-primary">Elegir</a>
                    </footer>
                  </div>
                </div>
                
                <div class="column is-4">
                  <div class="card">
                    <div class="card-content">
                      <p class="title is-4">Anual</p>
                      <p class="subtitle has-text-primary is-4">$99.99<span class="is-size-6">/año</span></p>
                      <div class="content">
                        <ul>
                          <li>Todo lo del plan Premium</li>
                          <li>¡2 meses gratis!</li>
                          <li>Acceso a archivo histórico</li>
                          <li>Edición digital descargable</li>
                        </ul>
                      </div>
                    </div>
                    <footer class="card-footer">
                      <a href="#" class="card-footer-item button is-primary is-light">Elegir</a>
                    </footer>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
        
        <!-- Preferencias de notificaciones -->
        <div class="box">
          <h3 class="title is-5 mb-4">Preferencias de correo y notificaciones</h3>
          
          <form>
            <div class="field">
              <div class="control">
                <label class="checkbox">
                  <input type="checkbox" checked>
                  Recibir boletín diario con las noticias más importantes
                </label>
              </div>
            </div>
            
            <div class="field">
              <div class="control">
                <label class="checkbox">
                  <input type="checkbox" checked>
                  Recibir notificaciones sobre artículos de mis temas de interés
                </label>
              </div>
            </div>
            
            <div class="field">
              <div class="control">
                <label class="checkbox">
                  <input type="checkbox">
                  Recibir ofertas especiales y promociones
                </label>
              </div>
            </div>
            
            <div class="field">
              <div class="control">
                <button type="submit" class="button is-small is-link is-light">
                  Guardar preferencias
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>