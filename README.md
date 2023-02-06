# Users

В проекте был использован фреймворк laminas/mezzio для роутинга
и doctrine для запросов к бд.

После клонирования репозитория нужно выполнить команды:

`docker-compose build backend`

`docker-compose up`

`docker-compose exec backend composer install`

`docker-compose exec backend ./vendor/bin/doctrine-migrations migrate -n`

В корне проекта находится файл `requests.http` для удобства тестирования.

Весь код, который находится в `docker`, `src` и `tests` написан самостоятельно.
Всё остальное - это часть фреймворка laminas/mezzio.
В каталоге `src` находится основной код. Он разделен по слоям:

`UserInterface` - контроллеры, валидаторы

`UseCase` - здесь находятся хендлеры, их вызывают контроллеры.

`Infrastructure` - репозитории и инфраструктурные сервисы

`Domain` - слой домена. Сущности бд, доменные исключения, интерфейсы репозиториев.

Миграция для таблицы `users` находится в `data/doctrine/migrations`

Роуты прописаны в `config/routes.php`

Валидация полей name, email и notes осуществляется валидатором
`UserInterface\Validator\UserDataValidator`.

Валидация `deleted` DateTime находится в самой сущности User, и при неверном значении
выбрасывается доменное исключение.

Журналирование изменений записи в бд происходит за счет подписки на события
изменения сущности. Подписчик находится в `Infrastructure/EventSubscriber`.
