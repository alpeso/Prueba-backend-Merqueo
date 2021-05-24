### Introduction

Se desarrollo un servicio REST que hace las veces de una caja registradora, que le ayudará a simular una caja registradora a través de una API REST.

Este sistema esta desarrollado en el lenguaje de programación PHP
haciendo uso del Framework Laravel, para el almacenamiento de datos se hace uso del
sistema de gestión de base de datos MySQL y para la seguridad de las peticiones se hace
uso del módulo laravel passport que implementa servicios de autentificación a los endpoints
por medio del protocolo Oauth2.

**El sistema tiene los siguientes servicios:**

1. Cargar base a la caja.
2. Vaciar caja.
3. Estado de caja.
4. Realizar un pago.
5. Ver registro de logs de eventos.
6. Saber estado de la caja según fecha y hora determinada.

### Instalación y configuración

**Luego de clonar el proyecto para configurar la caja registradora, ejecute los siguientes comandos:**

```
composer install
```
1. Cargue el contenido del archivo .env.example en el archivo .env
2. Cree una nueva base de datos.
3. Configure todos los parámetros de configuración en el archivo .env

Ejecute los comandos:

```
php artisan migrate
php artisan key:generate.
```
##### Install laravel passport

**Instalar el paquete Laravel Passport:**

Laravel Passport nos permite configurar un servidor de OAuth2 sobre nuestro Laravel en muy poco tiempo.

```
composer require laravel/passport
```

**Ejecutar las migraciones:**

El paquete Passport, al descargarse, incluye migraciones.

Es importante ejecutar estas migraciones, para contar con las tablas necesarias para guardar información de los clients y access tokens:

```
php artisan migrate
```

**Generar llaves:**

Para que nuestro proyecto pueda generar access tokens seguros es necesario contar con encryption keys (llaves que se usan en el proceso de encriptación).

Para ello debemos ejecutar:

```
php artisan passport:install
```

##### Pasos para ejecutar las pruebas

Configurar los accesos a la base de datos para las pruebas en el archivo phpunit.xml (DB_DATABASE) y ejecutar los comandos

```
php artisan config:clear 
```

```
vendor/bin/phpunit
```

##### Colecciones de Postman

Para configurar la colección de rutas en Postman, copie el archivo "Merqueo-CashRegister.postman_collection.json" en su computadora e impórtelo en la aplicación Postman.

Tenga en cuenta que primero debe generar el token y reemplazarlo en postman authorization, antes de poder usar los endpoints


##### Para ejecutar en local:

```
php artisan serve
```