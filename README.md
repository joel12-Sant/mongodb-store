# 🛍️ FrontEnd Store

**FrontEnd Store** es una tienda virtual creada como un proyecto escolar con fines académicos y prácticos. El objetivo es ofrecer una experiencia de compra real, enfocada en desarrolladores y estudiantes de programación. Esta aplicación demuestra el uso conjunto de tecnologías frontend y backend modernas, incluyendo PHP, MongoDB, y Docker.

---

## 🚀 Tecnologías utilizadas

- **PHP 8.1 (Apache)**
- **MongoDB**
- **phpMyAdmin**
- **Docker + Docker Compose**
- **HTML5 + CSS3**

---

## 📦 ¿Qué incluye este proyecto?

- Autenticación de usuarios
- Carrito de compras funcional
- Gestión de productos (admin)
- Historial de compras
- Manejo de sesiones
- Persistencia con base de datos MongoDB
- Interfaz moderna responsiva
- CRUD con Docker y volúmenes para persistencia

---

## ⚙️ Instalación rápida
1.- Clona el repositorio o descarga el .zip desde GitHub:

```bash
git clone https://github.com/joel12-Sant/mongodb-store.git
cd mongodb-store
```

2.- Construye y levanta los contenedores:
```bash
docker compose up --build
```
3.- Accede a tu aplicación:

- FrontEnd Store: http://localhost:8080

---

## 🐬 Servicios Docker
### MongoDB
- Imagen: Mongo

- Puerto: 27017

- Volumen persistente: mongo-init/

### Apache + PHP
- Imagen personalizada desde php:8.1-apache

- Extensiones: pdo_mysql, mongodb

- Puerto: 8080 -> 80

- Código fuente montado en /var/www/html

---

## ✅ Funcionalidades
- Registro e inicio de sesión de usuarios

- Roles (admin y cliente)

- Agregar y quitar productos del carrito

- Comprar productos (individual o todos)

- Historial de compras con detalle

- Eliminación de cuenta

- Administración de productos para admin

---

## 🔒 Seguridad
- Sanitización y validación de entradas

- Hashing de contraseñas con password_hash

- Control de acceso por sesión

---

## 📌 Notas
- Este sistema fue desarrolladon tambien con MySQL en un fase posterior, si deseas acceder ve a: https://github.com/joel12-Sant/Mysql-store

---

## 🧑‍💻 Autor
Desarrollado por Joel Matias Santiago & Alejandro Martinez Galeano.

---
## 📄 Licencia
Este proyecto es de uso libre con fines educativos.
