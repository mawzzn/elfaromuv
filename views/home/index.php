<!-- Contador total -->
<div class="container mt-4">
    <div class="notification is-light has-text-centered">
      Total de noticias: <strong id="contador-total">
        <?php 
          $total_articulos = 0;
          // Contar artículos generales
          if (isset($articulos_generales) && $articulos_generales->rowCount() > 0) {
            $total_articulos += $articulos_generales->rowCount();
          }
          // Contar artículos deportes
          if (isset($articulos_deportes) && $articulos_deportes->rowCount() > 0) {
            $total_articulos += $articulos_deportes->rowCount();
          }
          // Contar artículos negocios
          if (isset($articulos_negocios) && $articulos_negocios->rowCount() > 0) {
            $total_articulos += $articulos_negocios->rowCount();
          }
          echo $total_articulos;
        ?>
      </strong>
    </div>
  </div>    

  <!-- Artículo destacado -->
  <?php if ($articulos_destacados->rowCount() > 0): ?>
    <section class="section pt-0">
      <div class="container">
        <div class="columns">
          <div class="column is-8 is-offset-2">
            <?php 
              $articulo_destacado = $articulos_destacados->fetch(PDO::FETCH_ASSOC);
            ?>
            <article class="box featured-article has-background-light p-0">
              <div class="columns is-gapless">
                <div class="column is-7">
                  <figure class="image is-16by9">
                    <img src="assets/media/<?php echo $articulo_destacado['imagen']; ?>" alt="<?php echo $articulo_destacado['titulo']; ?>">
                  </figure>
                </div>
                <div class="column is-5">
                  <div class="p-5">
                    <span class="tag is-link is-medium mb-3">DESTACADO</span>
                    <h2 class="title is-3"><?php echo $articulo_destacado['titulo']; ?></h2>
                    <p class="subtitle is-6 mb-4"><?php echo substr($articulo_destacado['contenido'], 0, 150) . '...'; ?></p>
                    <a href="index.php?controller=articulo&action=mostrarDetalle&id=<?php echo $articulo_destacado['id']; ?>" class="button is-link is-outlined">Leer artículo completo</a>
                  </div>
                </div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- Sección de Inicio -->
  <section id="inicio" class="section">
    <div class="container">
      <!-- Título de sección con línea decorativa -->
      <div class="section-header">
        <h2 class="title is-3">Noticias Generales</h2>
        <div class="line"></div>
        <div class="ml-4">
          <div class="contador-articulos">
            Artículos: <span id="contador-inicio" class="tag is-info is-light">
              <?php echo isset($articulos_generales) ? $articulos_generales->rowCount() : 0; ?>
            </span>
          </div>
        </div>
      </div>
      
      <div class="columns is-multiline" id="contenedor-inicio">
        <?php 
          if (isset($articulos_generales) && $articulos_generales->rowCount() > 0):
            while ($articulo = $articulos_generales->fetch(PDO::FETCH_ASSOC)):
        ?>
        <!-- Noticia -->
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
        <?php 
            endwhile;
          else:
        ?>
        <div class="column is-12">
          <div class="notification is-info">
            No hay noticias disponibles en esta sección.
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>    
  </section>

  <div class="section-divider container"></div>

  <!-- Sección Deportes -->
  <section id="deportes" class="section">
    <div class="container">
      <div class="section-header">
        <h2 class="title is-3">Deportes</h2>
        <div class="line"></div>
        <div class="ml-4">
          <div class="contador-articulos">
            Artículos: <span id="contador-deportes" class="tag is-info is-light">
              <?php echo isset($articulos_deportes) ? $articulos_deportes->rowCount() : 0; ?>
            </span>
          </div>
        </div>
      </div>
      
      <div class="columns is-multiline" id="contenedor-deportes">
        <?php 
          if (isset($articulos_deportes) && $articulos_deportes->rowCount() > 0):
            while ($articulo = $articulos_deportes->fetch(PDO::FETCH_ASSOC)):
        ?>
        <!-- Noticia Deportiva -->
        <div class="column is-4">
          <div class="card">
            <div class="card-image">
              <figure class="image is-4by3">
                <img src="assets/media/<?php echo $articulo['imagen']; ?>" alt="<?php echo $articulo['titulo']; ?>">
              </figure>
            </div>
            <div class="card-content">
              <div class="article-meta">
                <span class="tag is-success"><?php echo $articulo['categoria_nombre']; ?></span>
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
        <?php 
            endwhile;
          else:
        ?>
        <div class="column is-12">
          <div class="notification is-info">
            No hay noticias deportivas disponibles.
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <div class="section-divider container"></div>

  <!-- Sección Negocios -->
  <section id="negocios" class="section">
    <div class="container">
      <div class="section-header">
        <h2 class="title is-3">Negocios</h2>
        <div class="line"></div>
        <div class="ml-4">
          <div class="contador-articulos">     
            Artículos: <span id="contador-negocios" class="tag is-info is-light">
              <?php echo isset($articulos_negocios) ? $articulos_negocios->rowCount() : 0; ?>
            </span>
          </div>
        </div>
      </div>
      
      <div class="columns is-multiline" id="contenedor-negocios">
        <?php 
          if (isset($articulos_negocios) && $articulos_negocios->rowCount() > 0):
            while ($articulo = $articulos_negocios->fetch(PDO::FETCH_ASSOC)):
        ?>
        <!-- Noticia de Negocios -->
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
        <?php 
            endwhile;
          else:
        ?>
        <div class="column is-12">
          <div class="notification is-info">
            No hay noticias de negocios disponibles.
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Resumen de noticias recientes en tarjetas pequeñas -->
  <section class="section has-background-light">
    <div class="container">
      <h3 class="title is-4 has-text-centered mb-5">Últimas Actualizaciones</h3>
      <div class="columns is-multiline">
        <!-- Noticias recientes en formato compacto -->
        <?php
          // Reiniciar cursor de artículos generales
          if (isset($articulos_generales) && $articulos_generales->rowCount() > 0) {
            $articulos_generales->execute(); // Reiniciar el statement
            $count = 0;
            while ($articulo = $articulos_generales->fetch(PDO::FETCH_ASSOC)) {
              if ($count >= 4) break; // Máximo 4 noticias
        ?>
        <div class="column is-3">
          <div class="card">
            <div class="card-content is-paddingless">
              <div class="media">
                <div class="media-left">
                  <figure class="image is-64x64">
                    <img src="assets/media/<?php echo $articulo['imagen']; ?>" alt="<?php echo $articulo['titulo']; ?>">
                  </figure>
                </div>
                <div class="media-content p-3">
                  <p class="title is-6"><?php echo substr($articulo['titulo'], 0, 30) . (strlen($articulo['titulo']) > 30 ? '...' : ''); ?></p>
                  <p class="subtitle is-7"><?php echo $articulo['categoria_nombre']; ?> | 
                    <?php 
                      $fecha = new DateTime($articulo['fecha_publicacion']);
                      $ahora = new DateTime();
                      $diff = $ahora->diff($fecha);
                      
                      if ($diff->days == 0) {
                        if ($diff->h == 0) {
                          echo 'Hace ' . $diff->i . 'm';
                        } else {
                          echo 'Hace ' . $diff->h . 'h';
                        }
                      } else if ($diff->days == 1) {
                        echo 'Ayer';
                      } else {
                        echo 'Hace ' . $diff->days . 'd';
                      }
                    ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
                $count++;
              }
            }
        ?>
      </div>
    </div>
  </section>

  <!-- Formulario para nuevas noticias - Solo visible para usuarios registrados -->
  <?php if(isset($_SESSION['id'])): ?>
  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="column is-8 is-offset-2">
          <div class="box">
            <h3 class="title is-4">Añadir Nueva Noticia</h3>
            <form id="formulario-articulo" action="index.php?controller=articulo&action=crear" method="post" enctype="multipart/form-data">
              <div class="field">
                <label class="label">Sección</label>
                <div class="control">
                  <div class="select is-fullwidth">
                    <select id="id_categoria" name="id_categoria" required>
                      <option value="">Seleccione una opción</option>
                      <?php
                        // Obtener todas las categorías
                        if (isset($categorias_stmt) && $categorias_stmt->rowCount() > 0) {
                          while ($categoria = $categorias_stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $categoria['id'] . '">' . $categoria['nombre'] . '</option>';
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="field">
                <label class="label">Título</label>
                <div class="control">
                  <input id="titulo" name="titulo" class="input" type="text" placeholder="Título de la noticia" required />
                </div>
              </div>
              <div class="field">
                <label class="label">Contenido</label>
                <div class="control">
                  <textarea id="contenido" name="contenido" class="textarea" placeholder="Contenido de la noticia" required></textarea>
                </div>
              </div>
              <div class="field">
                <label class="label">Imagen</label>
                <div class="control">
                  <div class="file has-name is-fullwidth">
                    <label class="file-label">
                      <input class="file-input" type="file" name="imagen" accept="image/*">
                      <span class="file-cta">
                        <span class="file-icon">
                          <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                          Seleccionar archivo
                        </span>
                      </span>
                      <span class="file-name">
                        Ningún archivo seleccionado
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="field">
                <label class="label">Etiquetas</label>
                <div class="control">
                  <input id="etiquetas" name="etiquetas" class="input" type="text" placeholder="Etiquetas separadas por comas" />
                </div>
              </div>
              <div class="field">
                <div class="control">
                  <label class="checkbox">
                    <input type="checkbox" name="destacado" value="1">
                    Destacar este artículo
                  </label>
                </div>
              </div>
              <div class="control">
                <button type="submit" name="guardar_articulo" class="button is-primary is-fullwidth">Publicar Noticia</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- Multimedia -->
  <section id="multimedia" class="section has-background-light">
    <div class="container">
      <div class="section-header">
        <h3 class="title is-4">Multimedia</h3>
        <div class="line"></div>
      </div>
      
      <div class="columns">
        <div class="column is-8">
          <div class="box">
            <h4 class="title is-5 mb-3">Video destacado</h4>
            <video width="100%" controls>
              <source src="assets/media/Video.mp4" type="video/mp4">
              Tu navegador no soporta el video.
            </video>
          </div>
        </div>
        <div class="column is-4">
          <div class="box">
            <h4 class="title is-5 mb-3">Podcast semanal</h4>
            <iframe style="border-radius:12px" src="https://open.spotify.com/embed/episode/5C7sNndEt1c0Zs7ADUljXQ?utm_source=generator" width="100%" height="152" frameborder="0" allowfullscreen allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
          </div>
          <div class="box">
            <h4 class="title is-5 mb-3">Síguenos</h4>
            <div class="buttons">
              <a class="button is-info" href="#"><i class="fab fa-twitter"></i></a>
              <a class="button is-link" href="#"><i class="fab fa-facebook-f"></i></a>
              <a class="button is-danger" href="#"><i class="fab fa-instagram"></i></a>
              <a class="button is-dark" href="#"><i class="fab fa-tiktok"></i></a>
              <a class="button is-success" href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>