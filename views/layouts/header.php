<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>El Faro - Periódico Digital</title>
  <!-- Importación de Bulma CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <!-- Importación de Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome para iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link href="assets/css/style.css" rel="stylesheet">
  
</head>
<body id="in">
  <!-- Sección superior de avisos -->
  <div class="notification is-announcement has-text-centered">
    <button class="delete"></button>
    <strong>¡Última hora!</strong> Descarga nuestra nueva aplicación para acceder a noticias exclusivas. <a href="#">Saber más</a>
  </div>

<!-- Encabezado -->
<!-- Encabezado responsivo y profesional -->
<header class="hero">
    <div class="hero-body py-4">
      <div class="container">
        <div class="columns is-vcentered is-mobile is-multiline">
          <!-- Logo -->
          <div class="column is-narrow is-flex is-align-items-center">
            <figure class="image is-48x48 mr-3">
              <img src="assets/media/faro.png" alt="Logo El Faro" class="has-shadow">
            </figure>
          </div>  
          <!-- Título y subtítulo -->
          <div class="column is-flex is-flex-direction-column is-justify-content-center">
            <h1 class="title is-4 mb-1">El Faro</h1>
            <p class="subtitle is-6 mb-0"><strong>Iluminando la verdad desde 1985</strong></p>
          </div>  
          <!-- Reloj a la derecha -->
          <div class="column is-narrow is-flex is-align-items-center is-justify-content-flex-end">
            <div id="reloj" class="has-text-grey is-size-7 is-flex is-align-items-center">
              <span class="icon mr-1">
                <i class="fas fa-clock"></i>
              </span>
              <span id="hora-actual"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Menú centrado y moderno -->
    <div class="navbar-container">
      <nav class="navbar is-transparent">
        <div class="container">
          <div class="navbar-brand">
            <!-- Botón hamburguesa para móviles - CORREGIDO -->
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </a>
          </div>
          <div id="navbarMenu" class="navbar-menu">
            <div class="navbar-start" style="margin: 0 auto;">
              <a class="navbar-item <?php echo (!isset($_GET['controller']) || $_GET['controller'] == 'home') ? 'is-active' : ''; ?> has-text-weight-bold" href="index.php">
                <span>INICIO</span>
              </a>
              <a class="navbar-item <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'articulo' && isset($_GET['id_categoria']) && $_GET['id_categoria'] == 2) ? 'is-active' : ''; ?> has-text-weight-bold" href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=2">
                <span>DEPORTE</span>
              </a>
              <a class="navbar-item <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'articulo' && isset($_GET['id_categoria']) && $_GET['id_categoria'] == 3) ? 'is-active' : ''; ?> has-text-weight-bold" href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=3">
                <span>NEGOCIOS</span>
              </a>
              <a class="navbar-item <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'multimedia') ? 'is-active' : ''; ?> has-text-weight-bold" href="#multimedia">
                <span>MULTIMEDIA</span>
              </a>
              <a class="navbar-item <?php echo (isset($_GET['controller']) && $_GET['controller'] == 'contacto') ? 'is-active' : ''; ?> has-text-weight-bold" href="index.php?controller=contacto&action=mostrarFormulario">
                <span>CONTACTO</span>
              </a>
              <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link has-text-weight-bold">
                  MÁS
                </a>
                <div class="navbar-dropdown">
                  <a class="navbar-item" href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=4">Cultura</a>
                  <a class="navbar-item" href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=5">Tecnología</a>
                  <a class="navbar-item" href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=6">Opinión</a>
                  <a class="navbar-item" href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=7">Internacional</a>
                </div>
              </div>
            </div>

            <div class="navbar-end">
              <?php if(isset($_SESSION['id'])): ?>
                <div class="navbar-item has-dropdown is-hoverable">
                  <a class="navbar-link has-text-weight-bold">
                    <i class="fas fa-user mr-1"></i> <?php echo $_SESSION['nombre']; ?>
                  </a>
                  <div class="navbar-dropdown is-right">
                    <a class="navbar-item" href="index.php?controller=usuario&action=perfil">Mi perfil</a>
                    <a class="navbar-item" href="index.php?controller=usuario&action=logout">Cerrar sesión</a>
                  </div>
                </div>
              <?php else: ?>
                <div class="navbar-item">
                  <div class="buttons">
                    <a class="button is-primary" href="index.php?controller=usuario&action=mostrarRegistro">
                      <strong>Registrarse</strong>
                    </a>
                    <a class="button is-light" href="index.php?controller=usuario&action=mostrarLogin">
                      Iniciar sesión
                    </a>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </nav>
    </div>

    <!-- Barra de categorías destacadas -->
    <div class="hero-foot">
      <div class="container">
        <nav class="tabs is-centered is-boxed">
          <ul>
            <li><a href="index.php?tag=ultima-hora">Última hora</a></li>
            <li><a href="index.php?tag=tendencias">Tendencias</a></li>
            <li><a href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=8">Política</a></li>
            <li><a href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=7">Internacional</a></li>
            <li><a href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=9">Economía</a></li>
          </ul>
        </nav>
      </div>
    </div>
</header>

<!-- Mostrar mensajes de éxito o error -->
<?php if(isset($_GET['success'])): ?>
  <div class="container mt-4">
    <div class="notification is-success">
      <?php 
        $success = $_GET['success'];
        switch($success) {
          case 'registro':
            echo 'Te has registrado correctamente';
            break;
          case 'login':
            echo 'Has iniciado sesión correctamente';
            break;
          case 'mensaje_enviado':
            echo 'Tu mensaje ha sido enviado correctamente';
            break;
          case 'articulo_creado':
            echo 'El artículo ha sido creado correctamente';
            break;
          case 'logout':
            echo 'Has cerrado sesión correctamente';
            break;
          default:
            echo 'Operación realizada con éxito';
        }
      ?>
    </div>
  </div>
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
  <div class="container mt-4">
    <div class="notification is-danger">
      <?php 
        $error = $_GET['error'];
        switch($error) {
          case 'email':
            echo 'Este email ya está registrado';
            break;
          case 'credenciales':
            echo 'Email o contraseña incorrectos';
            break;
          case 'mensaje_no_enviado':
            echo 'Ha ocurrido un error al enviar el mensaje';
            break;
          case 'articulo_no_creado':
            echo 'Ha ocurrido un error al crear el artículo';
            break;
          case 'password_mismatch':
            echo 'Las contraseñas no coinciden';
            break;
          case 'login_required':
            echo 'Debes iniciar sesión para acceder a esta página';
            break;
          default:
            echo 'Ha ocurrido un error';
        }
      ?>
    </div>
  </div>
<?php endif; ?>