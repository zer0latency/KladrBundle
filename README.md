# Symfony KladrBundle
## Описание
Bundle для Symfony 2.X для включения виджета kladr в Ваши формы.
## Установка
Для подключения бандла необходимо указать в composer.json:
```
    ...
    "repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/zer0latency/KladrBundle.git"
    },
    "require": {
        ...
        "zer0latency/kladr-bundle": "master@dev"
    }
```
Для работы bundle необходимо соблюсти несколько условий:
* `p7zip` - Необходимая утилита для распаковки *.7z
* `dbase.so` - Необходимое расширение PHP для работы с таблицами DBF (Уставнавливается спомощю `pecl install dbase`)
* `LOAD DATA INFILE` - Текущий вариант загрузки данных (отсюда следует, что bundle совместим только с MySQL), т. к. самый быстрый
* `mysqld` имеет доступ для чтения `/tmp/*` (см. конфигурацию apparmor - `/etc/apparmor.d/usr.sbin.mysqld`)

## Использование
Перед использованием незабудьте выполнить `php app/console doctrine:schema:update` для создания таблиц.

* `php app/console kladr:update` - Вариант команды с загрузкой файла Base.7z из Интернета
* `php app/console kladr:update --file='./Base.7z'` - Использовать уже загруженный файл.
* `php app/console kladr:update --directory='/tmp'` - Искать DBF-файлы в указанной директории.

Так же, необходимо добавить роутинг:
`app/config/routing.yml`
```
kladr:
    resource: "@KladrBundle/Controller/"
    type:     annotation
    prefix:   /
```
И шаблон формы для TWIG:
`app/config/config.yml`
```
twig:
    form:
        resources:
            - 'KladrBundle:Form:kladr_widget.html.twig'
```
