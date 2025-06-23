
# Tienda de Playeras - Proyecto CRUD con PHP y MongoDB

Este proyecto es una tienda en línea simple que permite gestionar playeras (camisetas) a través de un panel de administración con autenticación básica. Está desarrollado usando:

- PHP (sin frameworks)
- MongoDB
- Docker (opcional)
- HTML + CSS (con Bootstrap y estilos personalizados)
- CRUD completo: Crear, Leer, Actualizar y Eliminar productos

---


## ¿Cómo funciona?

1. **Inicio de sesión**
   - Solo usuarios autenticados pueden acceder a find.php, create.php, update.php y delete.php.
   - Usuario y contraseña están definidos directamente en login.php:
     - Usuario: admin
     - Contraseña: 1234 (usando password_hash y password_verify)

2. **Subida de imágenes**
   - Al agregar una playera, la imagen se guarda en la carpeta /img/ con un nombre numérico automático (1.jpg, 2.jpg...).
   - Al eliminar una playera, su imagen también se borra del servidor.

3. **Base de datos MongoDB**
   - Cada playera se guarda como un documento en la colección.
   - Campos: id, nombre, precio, cantidad, descripción, imagen.

4. **Protección por sesión**
   - Los archivos de administración inician con una verificación de sesión.
   - Si no hay sesión activa, se redirige a login.php.

---

## Requisitos

- PHP 7.4 o superior
- MongoDB (local o en Docker)
- Extensión php-mongodb instalada
- Navegador web moderno

---

## Uso

1. Ejecuta MongoDB
2. Inicia el servidor local con PHP:
   php -S localhost:8000
3. Abre en navegador: http://localhost:8000
4. Ve a login.php y entra con:
   - Usuario: admin
   - Contraseña: 1234

---

## Seguridad

- Contraseñas con password_hash y password_verify
- Archivos de administración protegidos por sesión
- Control de tipo de archivo al subir imágenes

---

## Mejoras posibles

- Guardar usuarios en MongoDB
- Agregar buscador en find.php
- Soporte a más tipos de imagen (PNG, WebP)
- Mejorar diseño responsivo

---

## Autor

Joel Matías y Alejandro Martinez Galeano
Proyecto escolar de desarrollo web con PHP + MongoDB
