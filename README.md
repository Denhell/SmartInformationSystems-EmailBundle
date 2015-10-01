Бандл для отправки писем.

# Настройка

В файле `app/config/services.yml` нужно ипортировать настройки сервисов:

```
imports:
    - { resource: @SmartInformationSystemsEmailBundle/Resources/config/services.yml }
```

В файле `app/config/config.yml` включить новый spool:

```
swiftmailer:
    ...
    spool:
        type: smart_information_systems_spool
```
