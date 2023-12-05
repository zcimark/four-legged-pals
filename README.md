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

![Screen Shot 2023-12-05 at 2 42 20 PM](https://github.com/zcimark/four-legged-pals/assets/54482154/538a0df5-cc90-4a26-9fc1-c26373e90673)

## Development Setup

Build the application image

`docker compose up`

Once completed, open terminal in repo directory and run this cmd to migrate the db

`docker compose exec -w /var/www web php bin/console doctrine:migrations:migrate`

Check things are working

`docker-compose ps`

Visit http://localhost:5173/build/pet 
