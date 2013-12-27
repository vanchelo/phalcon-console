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

Пара скриншотов
![Console Before Execute](http://i58.fastpic.ru/big/2013/1221/9d/fddb76f0f45ab5b665144e8dc7cd6f9d.jpg "Консоль до выполнеиня")
![Console After Execute](http://i58.fastpic.ru/big/2013/1221/19/a60efe026438b9a17b0ff8e73470ec19.jpg "Консоль после выполнеиня")
