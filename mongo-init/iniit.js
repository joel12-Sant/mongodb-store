db = db.getSiblingDB('tienda');

db.playeras.insertMany([
  {
    id: 1,
    nombre: 'VueJS',
    precio: 25,
    cantidad: 10,
    descripcion: 'Playera oficial de VueJS, cómoda y ligera.',
    imagen: '1.jpg'
  },
  {
    id: 2,
    nombre: 'AngularJS',
    precio: 25,
    cantidad: 8,
    descripcion: 'Playera AngularJS para fanáticos del framework.',
    imagen: '2.jpg'
  },
  {
    id: 3,
    nombre: 'ReactJS',
    precio: 25,
    cantidad: 15,
    descripcion: 'Playera ReactJS con diseño moderno.',
    imagen: '3.jpg'
  },
  {
    id: 4,
    nombre: 'ReduxJS',
    precio: 25,
    cantidad: 12,
    descripcion: 'Playera Redux para manejar el estado con estilo.',
    imagen: '4.jpg'
  },
  {
    id: 5,
    nombre: 'NodeJS',
    precio: 25,
    cantidad: 20,
    descripcion: 'Playera NodeJS para amantes del backend.',
    imagen: '5.jpg'
  },
  {
    id: 6,
    nombre: 'SazJS',
    precio: 25,
    cantidad: 7,
    descripcion: 'Playera SazJS con diseño exclusivo.',
    imagen: '6.jpg'
  },
  {
    id: 7,
    nombre: 'HTML5',
    precio: 25,
    cantidad: 18,
    descripcion: 'Playera HTML5 para diseñadores y desarrolladores web.',
    imagen: '7.jpg'
  },
  {
    id: 8,
    nombre: 'GitHub',
    precio: 25,
    cantidad: 25,
    descripcion: 'Playera GitHub para colaboraciones y código abierto.',
    imagen: '8.jpg'
  },
  {
    id: 9,
    nombre: 'Bulma',
    precio: 25,
    cantidad: 10,
    descripcion: 'Playera Bulma con estilo CSS moderno.',
    imagen: '9.jpg'
  },
  {
    id: 10,
    nombre: 'TypeScript',
    precio: 25,
    cantidad: 14,
    descripcion: 'Playera TypeScript para programadores estrictos.',
    imagen: '10.jpg'
  },
  {
    id: 11,
    nombre: 'Drupal',
    precio: 25,
    cantidad: 9,
    descripcion: 'Playera Drupal para entusiastas de CMS.',
    imagen: '11.jpg'
  },
  {
    id: 12,
    nombre: 'JavaScript',
    precio: 25,
    cantidad: 30,
    descripcion: 'Playera JavaScript, la reina del frontend.',
    imagen: '12.jpg'
  },
  {
    id: 13,
    nombre: 'GraphQL',
    precio: 25,
    cantidad: 6,
    descripcion: 'Playera GraphQL para APIs modernas.',
    imagen: '13.jpg'
  },
  {
    id: 14,
    nombre: 'WordPress',
    precio: 25,
    cantidad: 11,
    descripcion: 'Playera WordPress para creadores de sitios web.',
    imagen: '14.jpg'
  }
]);
