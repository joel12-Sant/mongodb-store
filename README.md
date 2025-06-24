
# Tienda de Playeras - Proyecto CRUD con PHP y MongoDB

Este proyecto es una tienda en línea simple que permite gestionar playeras (camisetas) a través de un panel de administración con autenticación básica. Está desarrollado usando:

- PHP (sin frameworks)
- MongoDB
- Docker
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

- solo se requiere tener instaldo docker en su dispositivo y descargar el zip de este repositorio o clonarlo en su dispositivo

---

## Uso

1. Ejecuta el comando: ```docker compose up --build ```
2. Abre en navegador: http://localhost:8080 para acceder al apartado de tienda
3. Para acceder al panel de administracion, ve a http://localhost:8080/find.php
4. Logeate con:
   - Usuario: admin
   - Contraseña: 1234

---

## Seguridad

- Contraseñas con password_hash y password_verify
- Archivos de administración protegidos por sesión
- Control de tipo de archivo al subir imágenes

---

## Autor

Joel Matías y Alejandro Martinez Galeano
Proyecto escolar de desarrollo web con PHP + MongoDB
