# BM-CORE PROJECT

## Running without Docker

If you use nginx/php-fpm or apache "native" on localhost.

Please config root to /root-project/src/public and enjoy project.

## Running with Docker (Local)

- **Config Laravel Environment**
    - Copy file `.env.example` to `.env` in root project
    - Edit the configuration to your liking.
    - If you want to know what is config in `.env` file.
    - Change your user in the file docker-compose line 6 `user: dungvn` => `user:..`
- **Build Image**
    - In root project, running below script to build image.
    - Build Image:
        - `docker-compose build` for build image.
- **Running App**
    - In root project, running below script to start app.
    - Running App in `docker-compose up -d`
- **Stopping App**
    - In root project, running script `docker-compose down` to stop app.

## Notes
1. **Running Artisan and Composer Command from Host**

Run this command: `docker exec -it bm-app <command of artisan>`
Example: `docker exec -it bm-app php artisan key:generate` for generate key in Laravel.

Run this command: `docker exec -it bm-app /bin/bash` login image.
Example: `composer install` for install package in Laravel.
