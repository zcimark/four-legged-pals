# FourLeggedPals
A simple Symfony and Vue.js application with the help of Vite. 

Technologies used:
Symfony
PHP
JavaScript
Vue 3
Vite
TypeScript
Twig
PostgreSQL
Docker
Doctrine


## Development Setup

Build the application image

`docker compose up`

Once completed, open terminal in repo directory and run this cmd to migrate the db

`docker compose exec -w /var/www web php bin/console doctrine:migrations:migrate`

Check things are working

`docker-compose ps`

Visit http://localhost:5173/build/pet 