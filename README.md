Phalcon Console
===============
Adapted by Phalcon https://github.com/darsain/laravel-console - Laravel 4 Console

AJAX console to execute PHP code in the browser with light, the ability to save the last code execution, limited access by IP address

Example, commissioning editor, click **Execute** `[Ctrl + Enter]`
 ```php
 $user = Users::findFirst(1);

 echo $user->name;
 ```
 Result
 ```php
 vanchelo
 ```

##Setting
###Via `composer`:
Add to file `composer.json` section `require`:
```
"vanchelo/phalcon-console": "dev-master"
```
```json
{
  "require": {
    "vanchelo/phalcon-console": "dev-master"
  }
}
```
In the terminal, run the command `composer update`


###Copy and paste:
* Copy the contents of a folder to any directory
* Register your autoloader namespace Vanchelo\Console
```php
// $loader = new Loader();

$loader->registerNamespaces(array(
    /* ... */
    'Vanchelo\Console' => __DIR__ . '/../library/console/src/', // Путь может быть другим
));
```

* Copy the contents of folders in your public folder accessible from public WEB
* Add Services

```php
/**
 * Register Console Service
 */
new Vanchelo\Console\ConsoleService($di);
```

* Add to the list of allowed IP addresses in the src/config/config.php

```php
/* ... */
'whitelist' => [
    '127.0.0.1',
    '::1'
],
/* ... */
```

Everything! The console must be available at http://site.com/phalcon-console

As in the console are available all the services and service

## Your settings
To specify your settings console, you must:
- Create a configuration file in a convenient location, such as this content
```php
<?php
// app/config/console-config.php
return new \Phalcon\Config([
    // If you want to specify the class test access rights to the console
    'check_access_class' => 'MyConsoleAccessCheck',

    // Check the permissions on the IP
    'check_ip' => false, // disable scanning by IP address
]);
```
- Sign-up in the container service settings console to initialize the service console
```php
$di['console.config'] = function ()
{
    // Path to correct its
    $config = require '/path/to/console-config.php';

    return $config;
};

new \Vanchelo\Console\ConsoleService($di);
```

For more precise information about the time of initializing the console and run the code, you must file `index.php` in your application to add to the rest of the code mark. line:

```php
define('PHALCONSTART', microtime(true));
```
It should look something like this:
```php
<?php
// public/index.php
define('PHALCONSTART', microtime(true));
```

A couple of screenshots
![Console Before Execute](http://i58.fastpic.ru/big/2013/1221/9d/fddb76f0f45ab5b665144e8dc7cd6f9d.jpg "Консоль до выполнеиня")
![Console After Execute](http://i58.fastpic.ru/big/2013/1221/19/a60efe026438b9a17b0ff8e73470ec19.jpg "Консоль после выполнеиня")
