/**
 * Script principal para el sitio web El Faro
 */
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar hora actual
    updateCurrentTime();
    
    // Inicializar botones de borrado de notificaciones
    initializeDeleteButtons();
    
    // Inicializar menú hamburguesa para móviles
    initializeBurgerMenu();
    
    // Inicializar contadores de artículos
    initializeArticleCounters();
    
    // Inicializar selector de archivos para formularios
    initializeFileInputs();
    
    // Inicializar mensajes temporales
    initializeTemporaryMessages();
  });
  
  /**
   * Actualizar la hora actual en tiempo real
   */
  function updateCurrentTime() {
    const horaElement = document.getElementById('hora-actual');
    if (horaElement) {
      const updateTime = () => {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        horaElement.textContent = `${hours}:${minutes}:${seconds}`;
      };
      
      // Actualizar inmediatamente y luego cada segundo
      updateTime();
      setInterval(updateTime, 1000);
    }
  }
  
  /**
   * Inicializar botones de borrado para notificaciones
   */
  function initializeDeleteButtons() {
    const deleteButtons = document.querySelectorAll('.delete');
    deleteButtons.forEach(button => {
      button.addEventListener('click', () => {
        const notification = button.parentNode;
        notification.parentNode.removeChild(notification);
      });
    });
  }
  
  /**
   * Inicializar menú hamburguesa para móviles
   */
  function initializeBurgerMenu() {
    const navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    if (navbarBurgers.length > 0) {
      navbarBurgers.forEach(burger => {
        burger.addEventListener('click', () => {
          const targetId = burger.dataset.target;
          const targetMenu = document.getElementById(targetId);
          
          burger.classList.toggle('is-active');
          targetMenu.classList.toggle('is-active');
        });
      });
    }
  }
  
  /**
   * Inicializar contadores de artículos
   */
  function initializeArticleCounters() {
    // Inicializar contador total
    const totalCounter = document.getElementById('contador-total');
    if (totalCounter) {
      updateTotalCounter();
    }
    
    // Listeners para cuando se agregan o eliminan artículos
    const formularioArticulo = document.getElementById('formulario-articulo');
    if (formularioArticulo) {
      formularioArticulo.addEventListener('submit', function(event) {
        // Este código se ejecutará después de enviar el formulario
        // La actualización real de contadores se hará después de la recarga de la página
      });
    }
  }
  
  /**
   * Actualizar el contador total de artículos
   */
  function updateTotalCounter() {
    const inicioCounter = document.getElementById('contador-inicio');
    const deportesCounter = document.getElementById('contador-deportes');
    const negociosCounter = document.getElementById('contador-negocios');
    const totalCounter = document.getElementById('contador-total');
    
    if (totalCounter) {
      let total = 0;
      
      if (inicioCounter) {
        total += parseInt(inicioCounter.textContent) || 0;
      }
      
      if (deportesCounter) {
        total += parseInt(deportesCounter.textContent) || 0;
      }
      
      if (negociosCounter) {
        total += parseInt(negociosCounter.textContent) || 0;
      }
      
      totalCounter.textContent = total;
    }
  }
  
  /**
   * Inicializar inputs de archivo para mostrar el nombre del archivo seleccionado
   */
  function initializeFileInputs() {
    const fileInputs = document.querySelectorAll('.file input[type=file]');
    fileInputs.forEach(input => {
      input.addEventListener('change', event => {
        const fileName = event.target.files[0]?.name || 'Ningún archivo seleccionado';
        const fileNameElement = input.parentNode.querySelector('.file-name');
        if (fileNameElement) {
          fileNameElement.textContent = fileName;
        }
      });
    });
  }
  
  /**
   * Inicializar mensajes temporales que desaparecen después de un tiempo
   */
  function initializeTemporaryMessages() {
    const tempMessages = document.querySelectorAll('.notification:not(.is-permanent)');
    tempMessages.forEach(message => {
      setTimeout(() => {
        if (message && message.parentNode) {
          message.classList.add('is-fading');
          setTimeout(() => {
            if (message && message.parentNode) {
              message.parentNode.removeChild(message);
            }
          }, 500);
        }
      }, 5000);
    });
  }
  
  /**
   * Validar formulario de contacto
   */
  function validateContactForm() {
    const form = document.querySelector('form[action*="contacto"]');
    if (form) {
      form.addEventListener('submit', function(event) {
        const emailInput = form.querySelector('input[type="email"]');
        const messageInput = form.querySelector('textarea');
        
        let isValid = true;
        
        // Validar email
        if (emailInput && !isValidEmail(emailInput.value)) {
          isValid = false;
          emailInput.classList.add('is-danger');
        } else if (emailInput) {
          emailInput.classList.remove('is-danger');
        }
        
        // Validar mensaje
        if (messageInput && messageInput.value.length < 10) {
          isValid = false;
          messageInput.classList.add('is-danger');
        } else if (messageInput) {
          messageInput.classList.remove('is-danger');
        }
        
        if (!isValid) {
          event.preventDefault();
          alert('Por favor, complete correctamente todos los campos del formulario.');
        }
      });
    }
  }
  
  /**
   * Validar dirección de email
   */
  function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  }
  
  /**
   * Validar formulario de registro
   */
  function validateRegisterForm() {
    const form = document.querySelector('form[action*="registrar"]');
    if (form) {
      form.addEventListener('submit', function(event) {
        const password = form.querySelector('input[name="password"]');
        const confirmPassword = form.querySelector('input[name="confirm_password"]');
        
        if (password && confirmPassword && password.value !== confirmPassword.value) {
          event.preventDefault();
          alert('Las contraseñas no coinciden');
          password.classList.add('is-danger');
          confirmPassword.classList.add('is-danger');
        } else if (password && confirmPassword) {
          password.classList.remove('is-danger');
          confirmPassword.classList.remove('is-danger');
        }
      });
    }
  }
  
  /**
   * Mostrar vista previa de la imagen seleccionada en el formulario de artículos
   */
  function showImagePreview() {
    const imageInput = document.querySelector('input[name="imagen"]');
    if (imageInput) {
      imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            // Buscar o crear elemento de vista previa
            let previewContainer = document.getElementById('image-preview-container');
            if (!previewContainer) {
              previewContainer = document.createElement('div');
              previewContainer.id = 'image-preview-container';
              previewContainer.className = 'mt-3';
              imageInput.parentNode.parentNode.parentNode.appendChild(previewContainer);
            }
            
            previewContainer.innerHTML = `
              <p class="has-text-centered mb-2">Vista previa:</p>
              <figure class="image is-4by3">
                <img src="${e.target.result}" alt="Vista previa">
              </figure>
            `;
          };
          reader.readAsDataURL(file);
        }
      });
    }
  }
  
  // Inicializar funciones de validación al cargar el documento
  document.addEventListener('DOMContentLoaded', function() {
    validateContactForm();
    validateRegisterForm();
    showImagePreview();
    
    // Inicializar botón para volver arriba
    initBackToTopButton();
  });
  
  /**
   * Inicializar botón para volver arriba
   */
  function initBackToTopButton() {
    const backToTopButton = document.querySelector('.back-to-top');
    if (backToTopButton) {
      // Ocultar el botón inicialmente
      backToTopButton.style.display = 'none';
      
      // Mostrar u ocultar botón según la posición de desplazamiento
      window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
          backToTopButton.style.display = 'flex';
          backToTopButton.classList.add('is-fadein');
        } else {
          backToTopButton.classList.remove('is-fadein');
          backToTopButton.classList.add('is-fadeout');
          setTimeout(() => {
            if (window.pageYOffset <= 300) {
              backToTopButton.style.display = 'none';
              backToTopButton.classList.remove('is-fadeout');
            }
          }, 300);
        }
      });
      
      // Manejar clic en el botón
      backToTopButton.addEventListener('click', function(event) {
        event.preventDefault();
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });
    }
  }