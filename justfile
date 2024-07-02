start:
    docker compose up -d
stop:
    docker compose down
restart: stop && start
destroy:
    docker compose down -v
rebuild:
    docker compose up -d --build --force-recreate --remove-orphans

php *command:
    docker compose exec app php {{command}}
composer *command:
    docker compose exec app composer {{command}}
artisan *command:
    docker compose exec app php artisan {{command}}

mysql *command:
    docker compose exec app mysql {{command}}
