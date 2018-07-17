# auth-server

## install

`composer require cblink/auth-server:dev-master -vvv`

## configure

`php artisan vendor:publish --provider="Cblink\AuthServer\AuthServiceProvider"`

this command will create a `auth app migration` and a `config/auth_server.php` 

you can modify the `auth_server.php` to change the table name and foreign id

## usage

### create a auth app table

`php artisan migrate`

### create a auth app

`php artisan auth:server:create`

### add middleware in kernel.php

```php
protected $routeMiddleware = [
// ...
    'open' => \Cblink\AuthServer\Http\Middleware\CheckSignature::class,
]
```
