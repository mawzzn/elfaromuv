<!-- Lista de artículos por categoría -->
<section class="section">
  <div class="container">
    <div class="columns">
      <div class="column is-12">
        <!-- Cabecera de la sección con migas de pan -->
        <nav class="breadcrumb" aria-label="breadcrumbs">
          <ul>
            <li><a href="index.php">Inicio</a></li>
            <li class="is-active"><a href="#" aria-current="page"><?php echo $nombre_categoria; ?></a></li>
          </ul>
        </nav>
        
        <div class="section-header">
          <h2 class="title is-3"><?php echo $nombre_categoria; ?></h2>
          <div class="line"></div>
          <div class="ml-4">
            <div class="contador-articulos">
              Artículos: <span class="tag is-info is-light"><?php echo $stmt->rowCount(); ?></span>
            </div>
          </div>
        </div>
        
        <!-- Filtros y ordenación -->
                
        <?php if($stmt->rowCount() > 0): ?>
          <div class="columns is-multiline">
            <?php while($articulo = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
              <div class="column is-4">
                <div class="card">
                  <div class="card-image">
                    <figure class="image is-4by3">
                      <img src="assets/media/<?php echo $articulo['imagen']; ?>" alt="<?php echo $articulo['titulo']; ?>">
                    </figure>
                  </div>
                  <div class="card-content">
                    <div class="article-meta">
                      <span class="tag is-primary"><?php echo $articulo['categoria_nombre']; ?></span>
                      <span class="article-date ml-2">
                        <?php 
                          $fecha = new DateTime($articulo['fecha_publicacion']);
                          $ahora = new DateTime();
                          $diff = $ahora->diff($fecha);
                          
                          if ($diff->days == 0) {
                            if ($diff->h == 0) {
                              echo 'Hace ' . $diff->i . ' minutos';
                            } else {
                              echo 'Hace ' . $diff->h . ' horas';
                            }
                          } else if ($diff->days == 1) {
                            echo 'Ayer';
                          } else {
                            echo 'Hace ' . $diff->days . ' días';
                          }
                        ?>
                      </span>
                    </div>
                    <h3 class="title is-5"><?php echo $articulo['titulo']; ?></h3>
                    <p><?php echo substr($articulo['contenido'], 0, 100) . '...'; ?></p>
                    <footer class="card-footer">
                      <a href="index.php?controller=articulo&action=mostrarDetalle&id=<?php echo $articulo['id']; ?>" class="card-footer-item">Leer más</a>
                    </footer>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
          
          <!-- Paginación -->
          <nav class="pagination is-centered mt-6" role="navigation" aria-label="pagination">
            <a class="pagination-previous" disabled>Anterior</a>
            <a class="pagination-next">Siguiente</a>
            <ul class="pagination-list">
              <li>
                <a class="pagination-link is-current" aria-label="Página 1" aria-current="page">1</a>
              </li>
              <li>
                <a class="pagination-link" aria-label="Ir a página 2">2</a>
              </li>
              <li>
                <a class="pagination-link" aria-label="Ir a página 3">3</a>
              </li>
            </ul>
          </nav>
        <?php else: ?>
          <div class="notification is-info">
            No hay artículos disponibles en esta categoría.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>