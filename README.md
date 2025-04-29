# Running laravel with docker

## Requirements
- Docker
- Docker Compose
- Composer
- Node.js
- NPM

## Docker Installation
- Clone the repository
- Copy the `.env.example` file to `.env`
- Update the `.env` file with your database credentials
- Update the `.env` parameter `DB_HOST` to `database`
- Run `composer install`
- Run `npm install`
- Run `npm run build`
- Run `docker-compose up -d`
- Run `docker-compose exec app php artisan key:generate`
- Run `docker-compose exec app php artisan migrate`
- Run `docker-compose exec app php artisan storage:link` if you want to use storage
- Run `docker-compose exec app php artisan optimize`
- Visit `http://localhost` in your browser

## Docker Commands
- `docker-compose up -d` to start the containers
- `docker-compose down` to stop the containers

## Database
- In docker-compose.yml you can choose database mysql or postgresql

___   
> unsorry@2025