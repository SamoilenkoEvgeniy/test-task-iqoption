## Тестовое задание IQ option

demo: [test.pidanova.ru](http://test.pidanova.ru)

### Используемые технологии

* php (laravel)
* mysql (db storage)
* redis (queue broker)
* supervisor (queue handler)  - поднимает нужное кол-во процессов на сервере

### Способ развертки приложения:

Чтобы приложениер работало корректно на сервере необходимо иметь:
1. php >= 7.0
2. MySQL = 5.7
2. redis current stable version

Последовательность действий:
1. Клонируем репо
2. composer install
3. chmod -R 0777 storage && chmod -R 0777 bootstrap/cache
4. cp .env.example .env
5. В .env файле нужно подставить БД и Пароль
6. sudo apt-get install supervisor
7. cp supervisor.config.stub /etc/supervisor/conf.d/laravel-worker
8. sudo supervisorctl reread && sudo supervisorctl update && sudo supervisorctl start laravel-worker:*

Готово! 

### Эндпоинты для запуска тасков:
#### get

* /tast/changeBalance
* /task/changeOperationStatus 
* /task/transferBalance