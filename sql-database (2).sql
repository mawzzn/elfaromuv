-- Script de creación de base de datos para El Faro
-- Ejecutar en MySQL/MariaDB

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS elfaro_db;
USE elfaro_db;

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  descripcion TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  apellido VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
  tipo_suscripcion ENUM('gratuito', 'basico', 'premium') DEFAULT 'gratuito',
  activo BOOLEAN DEFAULT TRUE,
  ultimo_login DATETIME,
  avatar VARCHAR(255) DEFAULT 'default-avatar.png',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de artículos
CREATE TABLE IF NOT EXISTS articulos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  contenido TEXT NOT NULL,
  imagen VARCHAR(255),
  id_categoria INT NOT NULL,
  fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
  etiquetas VARCHAR(255),
  autor VARCHAR(100),
  destacado BOOLEAN DEFAULT FALSE,
  visitas INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_categoria) REFERENCES categorias(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de comentarios
CREATE TABLE IF NOT EXISTS comentarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_articulo INT NOT NULL,
  id_usuario INT NOT NULL,
  contenido TEXT NOT NULL,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  aprobado BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_articulo) REFERENCES articulos(id) ON DELETE CASCADE,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de contactos
CREATE TABLE IF NOT EXISTS contactos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  asunto VARCHAR(255) NOT NULL,
  mensaje TEXT NOT NULL,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  leido BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de suscripciones al boletín
CREATE TABLE IF NOT EXISTS suscripciones_boletin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) NOT NULL UNIQUE,
  fecha_suscripcion DATETIME DEFAULT CURRENT_TIMESTAMP,
  activo BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar categorías por defecto
INSERT INTO categorias (nombre, descripcion) VALUES
('Noticias Generales', 'Noticias de carácter general y actualidad'),
('Deportes', 'Noticias deportivas'),
('Negocios', 'Noticias de economía y negocios'),
('Cultura', 'Noticias culturales y de entretenimiento'),
('Tecnología', 'Noticias sobre tecnología e innovación'),
('Opinión', 'Artículos de opinión'),
('Internacional', 'Noticias internacionales'),
('Política', 'Noticias políticas'),
('Economía', 'Noticias económicas');

-- Insertar usuario administrador por defecto
INSERT INTO usuarios (nombre, apellido, email, password, tipo_suscripcion) VALUES
('Admin', 'El Faro', 'admin@elfaro.com', '$2y$10$6oC14K.9iMZe.bRRKcpLTeUhE5BLI2mJRrwfaV3smdoRk1rLJfvPO', 'premium');
-- La contraseña es 'admin123' (hasheada con bcrypt)

-- Insertar algunos artículos de ejemplo
INSERT INTO articulos (titulo, contenido, imagen, id_categoria, autor, destacado) VALUES
('Buque Juan Sebastián Elcano abre sus puertas al público este fin de semana', 'Con casi un siglo de historia surcando los mares, el buque escuela Juan Sebastián Elcano, de La Armada Española, se encuentra atracado en Valparaíso. La embarcación lleva a bordo a 267 tripulantes, entre ellos guardiamarinas, marineros, Oficiales extranjeros e integrantes de otras ramas de las Fuerzas Armadas.', 'buque san juan.jpg', 1, 'Redacción El Faro', TRUE),
('Pescadores artesanales de Caleta Lo Rojas suspenden sus servicios a empresa Blumar', 'La decisión fue anunciada por la Asociación Gremial Lo Rojas de Coronel, en solidaridad con las familias de los siete tripulantes desaparecidos de la lancha Bruma. La Asociación Gremial Lo Rojas de Coronel, dio a conocer que los pescadores artesanales de la caleta suspenderán los servicios a la empresa Blumar.', 'Lo_Rojas.jpg', 1, 'Carlos Pérez', FALSE),
('¿Qué hora es? Chile vivió el cambio al horario de invierno', 'En concreto, a las 00:00 horas los relojes se atrasaron hasta las 23:00 horas en parte de Chile. El cambio al horario de invierno dejó de regir en las regiones de Arica y Parinacota, Tarapacá, Antofagasta, Atacama, Ñuble, Biobío, La Araucanía, Los Ríos, Los Lagos, Aysén y Magallanes. La modificación se llevará a cabo a las 24:00 horas del tercer sábado de abril.', 'que hora es.jpg', 1, 'María González', FALSE),
('Gareca nunca asumió con total compromiso dirigir a la Selección Chilena', '"Es un técnico que consiguió muchas cosas, probablemente tiene poca hambre de seguir consiguiendo más y creo que lo demostró en los hechos", aseguró Fernando Tapia. Según el CEO del sitio AS Chile, se trata de un entrenador que llegó a Chile convocando a jugadores que no habían mostrado un buen rendimiento.', 'Gareca dt chile.jpg', 2, 'Juan Rodríguez', FALSE),
('Martín Vidaurre vuelve al circuito mundial de Cross Country este fin de semana', 'La figura nacional del mountain bike dirá presente en la primera fecha de la UCI World Series en terreno sudamericano. Martín Vidaurre (Lexware) volverá a decir presente en el circuito mundial de Cross Country, específicamente en la primera fecha de la UCI World Series en Brasil.', 'Martin Vidaurre.jpg', 2, 'Pablo Muñoz', TRUE),
('El violento accidente que impactó en la Fórmula 1', 'El piloto de Alpine, Jack Doohan, protagonizó un brutal accidente en los entrenamientos libres del Gran Premio de Japón. El australiano Jack Doohan, debutante con Alpine, protagonizó un impactante accidente en la Fórmula 1, tras chocar contra las barreras en la tercera práctica libre del Gran Premio de Japón.', 'accidente.jpg', 2, 'Sebastián Torres', FALSE),
('El CEO de JPMorgan Chase asegura que los aranceles de Trump incrementan la inflación', 'El consejero delegado del banco estadounidense JPMorgan Chase, Jamie Dimon, ha asegurado este lunes que los aranceles adoptados se traducirán en un alza de la inflación. Además, ha destacado que es necesario que la Fed tenga en cuenta a sus aliados a la hora de tomar sus decisiones.', 'CEO.jpeg', 3, 'Ana Castro', TRUE),
('Aranceles: Marcel resalta la magnitud del "shock" y deja en suspenso reforma al impuesto a la renta', 'Tras hacer un repaso de los impactos financiero que volvieron a remecer a los mercados del mundo en medio de la guerra comercial. El ministro de Hacienda dijo, respecto de la reforma al impuesto a la renta que en este punto "vamos a tener que considerar todos los elementos cuando ya tengamos una visión completa" de lo que vaya ocurriendo.', 'aranceles.jpg', 3, 'Roberto Álvarez', FALSE),
('Extrema volatilidad pone a las acciones de EE.UU. en una montaña rusa', 'Las acciones de EE.UU. cayeron en su mayoría tras un extremadamente volátil lunes, cayendo, subiendo y luego rebotando en todas direcciones. Los temores de un conflicto más amplio en el Medio Oriente, la posibilidad de un cambio en la política monetaria de Japón y la preocupación por las elecciones estadounidenses han mantenido a los inversores alerta.', 'Extrema volatilidad.jpg', 3, 'Carmen Vega', FALSE);

-- Insertar algunos comentarios de ejemplo
INSERT INTO comentarios (id_articulo, id_usuario, contenido, aprobado) VALUES
(1, 1, 'Excelente noticia. Estaré visitando el buque este fin de semana.', TRUE),
(2, 1, 'Es importante el apoyo a las familias afectadas.', TRUE),
(3, 1, 'Gracias por la información sobre el cambio de hora.', TRUE);
