## Запуск в Docker

    docker-compose build
    docker-compose up -d

Установка зависимостей

    docker exec -i book24_php bash -c "cd /var/www/book24_transactions && composer install --no-plugins"

После успешной сборки и запуска проект будет доступен по адресу

    http://localhost:8000