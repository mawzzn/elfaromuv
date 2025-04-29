<!-- Detalle de artículo -->
<section class="section">
  <div class="container">
    <div class="columns">
      <div class="column is-8 is-offset-2">
        <!-- Navegación de migas de pan -->
        <nav class="breadcrumb mb-5" aria-label="breadcrumbs">
          <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="index.php?controller=articulo&action=listarPorCategoria&id_categoria=<?php echo $this->articulo->id_categoria; ?>"><?php echo $this->articulo->categoria_nombre; ?></a></li>
            <li class="is-active"><a href="#" aria-current="page"><?php echo $this->articulo->titulo; ?></a></li>
          </ul>
        </nav>

        <article class="box">
          <h1 class="title is-2"><?php echo $this->articulo->titulo; ?></h1>
          
          
          
          <!-- Imagen principal -->
          <figure class="image is-16by9 mb-5">
            <img src="assets/media/<?php echo $this->articulo->imagen; ?>" alt="<?php echo $this->articulo->titulo; ?>">
          </figure>
          
          <!-- Contenido del artículo -->
          <div class="content is-size-5">
            <?php echo nl2br($this->articulo->contenido); ?>
          </div>
          
          <!-- Etiquetas -->
          <?php if (!empty($this->articulo->etiquetas)): ?>
            <div class="tags mt-5">
              <?php
                $etiquetas = explode(',', $this->articulo->etiquetas);
                foreach ($etiquetas as $etiqueta) {
                  echo '<span class="tag is-medium is-light">' . trim($etiqueta) . '</span>';
                }
              ?>
            </div>
          <?php endif; ?>
          
          <!-- Compartir -->
          <div class="field is-grouped mt-6">
            <p class="control">
              <button class="button is-info">
                <span class="icon">
                  <i class="fab fa-twitter"></i>
                </span>
                <span>Twitter</span>
              </button>
            </p>
            <p class="control">
              <button class="button is-link">
                <span class="icon">
                  <i class="fab fa-facebook-f"></i>
                </span>
                <span>Facebook</span>
              </button>
            </p>
            <p class="control">
              <button class="button is-danger">
                <span class="icon">
                  <i class="fas fa-envelope"></i>
                </span>
                <span>Email</span>
              </button>
            </p>
          </div>
        </article>
        
        <!-- Sección de comentarios -->
        <div class="box mt-6">
          <h3 class="title is-4">Comentarios</h3>
          
          <?php if(isset($_SESSION['id'])): ?>
            <!-- Formulario de comentarios -->
            <form action="index.php?controller=comentario&action=crear" method="post" class="mb-5">
              <input type="hidden" name="id_articulo" value="<?php echo $this->articulo->id; ?>">
              <div class="field">
                <div class="control">
                  <textarea class="textarea" name="contenido" placeholder="Escribe tu comentario" required></textarea>
                </div>
              </div>
              <div class="field">
                <div class="control">
                  <button type="submit" name="enviar_comentario" class="button is-primary">Publicar comentario</button>
                </div>
              </div>
            </form>
          <?php else: ?>
            <div class="notification is-info">
              <p>Para dejar un comentario, por favor <a href="index.php?controller=usuario&action=mostrarLogin">inicia sesión</a> o <a href="index.php?controller=usuario&action=mostrarRegistro">regístrate</a>.</p>
            </div>
          <?php endif; ?>
          
          <!-- Lista de comentarios -->
          <div class="comments-list">
            <p class="has-text-grey">No hay comentarios todavía. Sé el primero en comentar.</p>
            
            <!-- Los comentarios se cargarían desde la base de datos si se implementa esta funcionalidad -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Artículos relacionados -->
<section class="section has-background-light">
  <div class="container">
    <h3 class="title is-4 mb-5">Artículos relacionados</h3>
    
    <div class="columns is-multiline">
      <!-- Los artículos relacionados se cargarían desde la base de datos si se implementa esta funcionalidad -->
      <div class="column is-12">
        <div class="notification is-light">
          No hay artículos relacionados disponibles en este momento.
        </div>
      </div>
    </div>
  </div>
</section>