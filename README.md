Phalcon Console
===============
[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/vanchelo/phalcon-console/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

Адаптированная под Phalcon https://github.com/darsain/laravel-console - Laravel 4 Console

AJAX Консоль для выполнения PHP кода в браузере с подсветкой, возможностью сохранения последнего выполненного кода, ограничением доступа по IP адресу

 Пример, вводим в окно редактора, нажимаем **Execute** `[Ctrl+Enter]`
 ```php
 $user = Users::findFirst(1);

 echo $user->name;
 ```
 Результат
 ```php
 vanchelo
 ```

##Установка
- Через `composer`:
Добавить в файл `composer.json` в секцию `require` `"vanchelo/phalcon-console": "dev-master"`
```json
{
  "require": {
    ...
    "vanchelo/phalcon-console": "dev-master"
    ...
  }
}
```

- Копи-паст:
* Скопировать содержимое папки в любой каталог
* Зарегистрировать в вашем автозагрузчике namespace Vanchelo\Console
```php
// $loader = new Loader();

$loader->registerNamespaces(array(
    /* ... */
    'Vanchelo\Console' => __DIR__ . '/../library/console/src/', // Путь может быть другим
));
```

* Скопировать содержимое папки public в вашу public папку доступную из WEB
* Добавить в сервисы

```php
/**
 * Register Console Service
 */
new Vanchelo\Console\ConsoleService($di);
```

* Добавить список разрешенных IP адресов в src/config/config.php

```php
/* ... */
'whitelist' => [
    '127.0.0.1',
    '::1'
],
/* ... */
```

Всё! Консоль должна быть доступна по адресу http://site.com/phalcon-console

Так же в консоле доступны все сервисы и службы

## Свои настройки
Для указания своих настроек консоли необходимо:
- Создать файл с настройками в удобном месте, например такого содержания
```php
<?php
// app/config/console-config.php
return new \Phalcon\Config([
    // Если хотим указать свой класс проверки прав доступа к консоли
    'check_access_class' => 'MyConsoleAccessCheck',

    // Проверка прав доступа по IP
    'check_ip' => false, // Отключаем проверку по IP адресу
]);
```
- Зарегистрировать в контейнере сервис настроек консоли до инициализации сервиса консоли
```php
$di['console.config'] = function ()
{
    // Пути исправить на свои
    $config = require '/path/to/console-config.php';

    return $config;
};

new \Vanchelo\Console\ConsoleService($di);
```

Для более точного информирования о времени инициализации консоли и исполнения кода, необходимо в файле `index.php` вашего приложения добавить перед остальным кодом, след. строку:

```php
define('PHALCONSTART', microtime(true));
```
Должно получится примерно так:
```php
<?php
// public/index.php
define('PHALCONSTART', microtime(true));
```

Пара скриншотов
![Console Before Execute](http://i58.fastpic.ru/big/2013/1221/9d/fddb76f0f45ab5b665144e8dc7cd6f9d.jpg "Консоль до выполнеиня")
![Console After Execute](http://i58.fastpic.ru/big/2013/1221/19/a60efe026438b9a17b0ff8e73470ec19.jpg "Консоль после выполнеиня")
