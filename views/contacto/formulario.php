<!-- Formulario de contacto -->
<section class="section">
  <div class="container">
    <div class="columns">
      <div class="column is-8 is-offset-2">
        <h1 class="title is-2 has-text-centered mb-6">Contacto</h1>
        
        <div class="columns mb-6">
          <div class="column is-6">
            <div class="box has-background-light">
              <h3 class="title is-4 mb-4">Información de contacto</h3>
              <div class="content">
                <p><i class="fas fa-map-marker-alt mr-2"></i> <strong>Dirección:</strong> Av. Principal 123, Santiago</p>
                <p><i class="fas fa-phone mr-2"></i> <strong>Teléfono:</strong> 123-456-789</p>
                <p><i class="fas fa-envelope mr-2"></i> <strong>Email:</strong> contacto@elfaro.com</p>
                <p><i class="fas fa-clock mr-2"></i> <strong>Horario:</strong> Lunes a Viernes, 9:00 - 18:00</p>
              </div>
              
              <h4 class="title is-5 mt-5 mb-3">Síguenos en redes sociales</h4>
              <div class="buttons">
                <a class="button is-info" href="#"><i class="fab fa-twitter"></i></a>
                <a class="button is-link" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="button is-danger" href="#"><i class="fab fa-instagram"></i></a>
                <a class="button is-dark" href="#"><i class="fab fa-tiktok"></i></a>
                <a class="button is-success" href="#"><i class="fab fa-whatsapp"></i></a>
              </div>
            </div>
          </div>
          <div class="column is-6">
            <div class="box has-background-light">
              <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26654.991711377003!2d-70.6776335!3d-33.4504545!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662c5410425af2f%3A0x8475d53c400f0931!2sSantiago%2C%20Regi%C3%B3n%20Metropolitana%2C%20Chile!5e0!3m2!1ses!2s!4v1650000000000!5m2!1ses!2s" 
                width="100%" 
                height="250" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
              </iframe>
            </div>
          </div>
        </div>
        
        <div class="box">
          <h3 class="title is-4 mb-4">Envíanos un mensaje</h3>
          
          <form action="index.php?controller=contacto&action=enviar" method="post">
            <div class="field">
              <label class="label">Nombre completo</label>
              <div class="control has-icons-left">
                <input class="input" type="text" name="nombre" placeholder="Tu nombre" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </div>
            </div>
            
            <div class="field">
              <label class="label">Correo electrónico</label>
              <div class="control has-icons-left">
                <input class="input" type="email" name="email" placeholder="Tu correo electrónico" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
              </div>
            </div>
            
            <div class="field">
              <label class="label">Asunto</label>
              <div class="control has-icons-left">
                <input class="input" type="text" name="asunto" placeholder="Asunto del mensaje" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-heading"></i>
                </span>
              </div>
            </div>
            
            <div class="field">
              <label class="label">Mensaje</label>
              <div class="control">
                <textarea class="textarea" name="mensaje" placeholder="Escribe tu mensaje aquí..." rows="5" required></textarea>
              </div>
            </div>
            
            <div class="field">
              <div class="control">
                <label class="checkbox">
                  <input type="checkbox" required>
                  Acepto la <a href="#">política de privacidad</a> y el <a href="#">tratamiento de datos</a>
                </label>
              </div>
            </div>
            
            <div class="field">
              <div class="control">
                <button type="submit" name="enviar_contacto" class="button is-primary is-fullwidth">Enviar mensaje</button>
              </div>
            </div>
          </form>
        </div>
        
        <div class="content mt-6">
          <h3 class="title is-4">Preguntas frecuentes</h3>
          
          <div class="message">
            <div class="message-header">
              <p>¿Cuál es el horario de atención al cliente?</p>
            </div>
            <div class="message-body">
              Nuestro equipo de atención al cliente está disponible de lunes a viernes, de 9:00 a 18:00 horas.
            </div>
          </div>
          
          <div class="message">
            <div class="message-header">
              <p>¿Cómo puedo suscribirme al periódico digital?</p>
            </div>
            <div class="message-body">
              Puedes registrarte en nuestra plataforma haciendo clic en el botón "Registrarse" en la parte superior de la página. Luego podrás elegir entre nuestros planes de suscripción.
            </div>
          </div>
          
          <div class="message">
            <div class="message-header">
              <p>¿Ofrecen descuentos para estudiantes?</p>
            </div>
            <div class="message-body">
              Sí, ofrecemos un 50% de descuento para estudiantes. Para acceder a este descuento, deberás verificar tu condición de estudiante enviándonos una copia de tu carnet estudiantil al correo estudiantes@elfaro.com.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>