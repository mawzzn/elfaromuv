<!-- Sección de suscripción -->
<section id="suscripcion" class="section has-background-primary">
    <div class="container">
      <div class="columns is-vcentered">
        <div class="column is-6">
          <h3 class="title is-3 has-text-white">Suscríbete a nuestro boletín</h3>
          <p class="subtitle is-5 has-text-white">Recibe las noticias más importantes directamente en tu correo.</p>
        </div>
        <div class="column is-6">
          <form action="index.php?controller=usuario&action=suscribirBoletin" method="post">
            <div class="field has-addons">
              <div class="control is-expanded">
                <input class="input is-medium" type="email" name="email" placeholder="Tu correo electrónico" required>
              </div>
              <div class="control">
                <button type="submit" name="suscribir_boletin" class="button is-dark is-medium">Suscribirme</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Pie de página mejorado -->
  <footer class="footer has-background-dark has-text-white">
    <div class="container">
      <div class="columns is-multiline">
        <div class="column is-12-mobile is-3-tablet">
          <h4 class="title is-4 has-text-white">El Faro</h4>
          <figure class="image is-96x96">
            <img src="assets/media/faro.png" alt="Logo El Faro">
          </figure>
          <p class="mt-3">Iluminando la verdad desde 1985. El periódico digital más confiable de la región.</p>
        </div>
        <div class="column is-12-mobile is-3-tablet">
          <h5 class="title is-5 has-text-white">Secciones</h5>
          <ul class="footer-menu">
            <li><a href="index.php" class="has-text-grey-light">Noticias Generales</a></li>
            <li><a href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=2" class="has-text-grey-light">Deportes</a></li>
            <li><a href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=3" class="has-text-grey-light">Negocios</a></li>
            <li><a href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=4" class="has-text-grey-light">Cultura</a></li>
            <li><a href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=5" class="has-text-grey-light">Tecnología</a></li>
            <li><a href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=6" class="has-text-grey-light">Opinión</a></li>
          </ul>
        </div>
        <div class="column is-12-mobile is-3-tablet">
          <h5 class="title is-5 has-text-white">Enlaces útiles</h5>
          <ul class="footer-menu">
            <li><a href="#" class="has-text-grey-light">Quiénes somos</a></li>
            <li><a href="#" class="has-text-grey-light">Términos y condiciones</a></li>
            <li><a href="#" class="has-text-grey-light">Política de privacidad</a></li>
            <li><a href="#" class="has-text-grey-light">Publicidad</a></li>
            <li><a href="index.php?controller=contacto&action=mostrarFormulario" class="has-text-grey-light">Contacto</a></li>
          </ul>
        </div>
        <div class="column is-12-mobile is-3-tablet">
          <h5 class="title is-5 has-text-white">Contacto</h5>
          <p><i class="fas fa-map-marker-alt mr-2"></i> Av. Principal 123, Santiago</p>
          <p><i class="fas fa-phone mr-2"></i> 123-456-789</p>
          <p><i class="fas fa-envelope mr-2"></i> contacto@elfaro.com</p>
          <div class="buttons mt-3">
            <a class="button is-small is-info is-outlined is-rounded" href="#"><i class="fab fa-twitter"></i></a>
            <a class="button is-small is-link is-outlined is-rounded" href="#"><i class="fab fa-facebook-f"></i></a>
            <a class="button is-small is-danger is-outlined is-rounded" href="#"><i class="fab fa-instagram"></i></a>
            <a class="button is-small is-dark is-outlined is-rounded" href="#"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>
      </div>
      <hr class="has-background-grey-dark">
      <div class="content has-text-centered">
        <p>© <?php echo date('Y'); ?> - El Faro - Todos los derechos reservados</p>
      </div>
    </div>
  </footer>

  <!-- Botón flotante para subir -->
  <a href="#in" class="button is-primary is-rounded back-to-top">
    <span class="icon">
      <i class="fas fa-arrow-up"></i>
    </span>
    <span>Ir a inicio</span>
  </a>

  <!-- Scripts -->
  <script src="assets/js/script.js"></script>
  <!-- Script específico para el menú móvil -->
  <script src="assets/js/menu-movil.js"></script>
  <script>
    // Script para el anuncio superior
    document.addEventListener('DOMContentLoaded', () => {
      // Funcionamiento del botón de cierre del anuncio
      const closeButton = document.querySelector('.notification .delete');
      if (closeButton) {
        closeButton.addEventListener('click', () => {
          const notification = closeButton.parentNode;
          notification.parentNode.removeChild(notification);
        });
      }
      
      // Actualizar hora actual
      function actualizarHora() {
        const horaElement = document.getElementById('hora-actual');
        if (horaElement) {
          const ahora = new Date();
          horaElement.textContent = ahora.toLocaleTimeString('es-ES');
        }
      }
      
      // Actualizar hora cada segundo
      actualizarHora();
      setInterval(actualizarHora, 1000);
      
      // Solo para depuración
      console.log("Footer cargado correctamente");
      console.log("Navbar burger:", document.querySelector('.navbar-burger'));
      console.log("Navbar menu:", document.getElementById('navbarMenu'));
    });
  </script>
</body>
</html>