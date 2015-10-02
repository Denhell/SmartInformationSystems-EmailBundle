Бандл для отправки писем.

# Настройка

В файле `app/config/config.yml` включить новый spool:

```
swiftmailer:
    ...
    spool:
        type: smart_information_systems_spool
```

Включить в crontab запуск команды рассылки писем `php app/console sis_email:send --env=dev`
