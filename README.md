\# Mars Rover Mission

\## Pasos para hacer funcionar el proyecto

1. Crear un nuevo directorio y cambiar a él:

mkdir nombre\_del\_directorio

cd nombre\_del\_directorio

1. Clonar el repositorio:

git clone https://github.com/adriangromero/mars-rover-mission.git .

1. Construir y levantar los servicios con Docker Compose en el perfil de desarrollo:

docker-compose up --build -d

docker-compose exec php bash

1. Dentro del contenedor, instalar dependencias y configurar el proyecto:

composer install

cp .env.example .env

php artisan key:generate

php artisan route:clear

exit

1. Acceder a la aplicación en el navegador:

http://localhost:5173/

\## Archivos principales de la app

\### Vue

- /frontend/src/components/Grid.vue
- /frontend/src/App.vue
- /frontend/src/main.js
- /frontend/src/api.js

\### Laravel

- /backend/routes/api.php
- /backend/app/Http/ControllersRoverController.php
- /backend/app/Services/Http/RoverService.php

php artisan test tests/Unit/RoverServiceTest.php
\## Llamadas de API

- `GET http://localhost/api/obstacles`: Obtener información sobre los obstáculos.
- `POST http://localhost/api/move`: Enviar comandos de movimiento.
