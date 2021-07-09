## Запуск через Docker

Создаем сеть
    
    docker network create --subnet=192.168.12.0/25 book24net

Поднимаем контейнеры

    docker-compose build
    docker-compose up -d

Устанавливаем зависимости

    docker exec -i book24_php bash -c "cd /var/www/book24_transactions && composer install"

Накатываем миграции и наполняем данными

    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load

или, используя контейнер Docker
    
    docker exec -i book24_php bash -c "cd /var/www/book24_transactions && php bin/console doctrine:migrations:migrate"
    docker exec -i book24_php bash -c "cd /var/www/book24_transactions && php bin/console doctrine:fixtures:load"
    

После успешной сборки и запуска проект будет доступен по адресу

    http://localhost:8010

PhpMyAdmin будет доступен по адресу (для подключения к БД надо указать адрес 192.168.12.11 и эзера/пароль - 
root/password)

    http://localhost:8011

## Запуск тестов

    php bin/phpunit

или, используя контейнер Docker

    docker exec -i book24_php bash -c "cd /var/www/book24_transactions && php bin/phpunit"
    

## Примечания

* Добавлено три эндпойнта
    ```
    GET /api/transaction - получение всех транзакий
    GET /api/transaction/{id} - получение транзакии по идентификатору
    POST /api/transaction - создание новой транзакции
   ```

* Реализована проверка условий проведения транзакции - должны быть переданы идентификаторы разных 
  балансов и сумма транзакции, балансы должны существовать, балансы должны отличаться, сумма 
  транзакции должна быть меньше или равна балансу, с которого совершается перевод

* Проведение транзакции реализовано через механизм транзакций, чтобы избежать некорректной работы 
  при сбоях

## Что можно улучшить

* Реализовать валидацию входных параметров через ассерты в модели транзакции, например, 
  через аннотации @Assert\NotBlank и прочие (пытался сделать, но не смог быстро разобраться 
  в валидаторе - не кастомизировались сообщения об ошибках)
  
* Если говорить о более серьзеной механике переводов с баланса на баланс, то стоило бы применить 
  что-то вроде бухгалтерских транзакций - с промежуточным системным балансом для контроля целостности 
  транзакций и возможностью ввода арбитража, добавить в проводки больше информации, перейти на типы 
  переводов - для возможности переводов не только на балансы, но и, например, за подписки внутри сервиса 
  и прочее

* Можно еще много чего придумать про безопасность (Например, авторизация платежей через OTP), 
  но тогда придется еще долго писать