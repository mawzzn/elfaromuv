/**
 * Script específico para hacer funcionar el menú hamburguesa en dispositivos móviles
 */
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los elementos con la clase navbar-burger
    var navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
  
    // Verificar si hay elementos navbar-burger
    if (navbarBurgers.length > 0) {
      console.log('Menú hamburguesa encontrado:', navbarBurgers.length);
      
      // Añadir un controlador de eventos click a cada uno
      navbarBurgers.forEach(function(el) {
        el.addEventListener('click', function() {
          console.log('Click en menú hamburguesa');
          
          // Obtener el target del dataset
          var target = el.dataset.target;
          console.log('Target del menú:', target);
          
          // Obtener el elemento objetivo
          var $target = document.getElementById(target);
          console.log('Elemento objetivo:', $target);
          
          if ($target) {
            // Alternar la clase is-active tanto en el burger como en el menú
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');
            console.log('Clases is-active alternadas');
          } else {
            console.error('No se encontró el elemento objetivo con ID:', target);
          }
        });
      });
    } else {
      console.error('No se encontraron elementos navbar-burger');
    }
  });