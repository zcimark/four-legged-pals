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
Clone repo

Build the containers and images

`docker compose up`

Once completed, open terminal in repo directory and install dependencies 
`docker compose exec -w /var/www web composer install && npm install`

Migrate the database using this command
`docker compose exec -w /var/www web php bin/console doctrine:migrations:migrate`

Check things are working

`docker-compose ps`

Visit http://localhost:5173/build/pet 