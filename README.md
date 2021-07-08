## Запуск через Docker

Создаем сеть
    
    docker network create --subnet=192.168.12.0/25 book24net

Поднимаем контейнеры

    docker-compose build
    docker-compose up -d

Установливаем зависимости

    docker exec -i book24_php bash -c "cd /var/www/book24_transactions && composer install"

Накатываем миграции и наполняем данными

    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load

После успешной сборки и запуска проект будет доступен по адресу

    http://localhost:8010

PhpMyAdmin будет доступен по адресу (для подключения к БД надо указать адрес 192.168.12.11 и эзера/пароль - 
root/password)

    http://localhost:8011