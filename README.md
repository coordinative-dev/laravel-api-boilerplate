Laravel API Boilerplate
================================
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/coordinative-dev/laravel-api-boilerplate/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/coordinative-dev/laravel-api-boilerplate/?branch=master)
[![Build Status](https://travis-ci.com/coordinative-dev/laravel-api-boilerplate.svg?branch=master)](https://travis-ci.com/coordinative-dev/laravel-api-boilerplate)

A RESTful application boilerplate in Laravel taking best practices and utilizing best available packages and tools.

It includes all commonly used configurations that would allow you to focus on adding new features to your application.

Demo: https://laravel-api.demo.coordinative.dev/api/documentation

FEATURES
------------
- RESTful endpoints in the widely accepted format
- JWT-based authentication
- Data validation
- Full test coverage
- Sign in, Sign up, Forgot Password, Update User Profile, Upload User Avatar
- Support Docker
- CircleCI integration

REQUIREMENTS
------------

The minimum requirements for this project:

- PHP 7.3
- Postgres 11.2
- Redis 5.5

Installing using Docker
-----------------------

> You need to have [docker](http://www.docker.com) (1.10.0+) and
[docker-compose](https://docs.docker.com/compose/install/) (1.6.0+) installed.

You can install the application using the following commands:

```bash
git clone https://github.com/Coordinative-dev/laravel-api-boilerplate.git
cd laravel-api-boilerplate
cp .env{.example,} && cp docker-compose.override.yml{.dist,}
docker-compose up -d --build
```

It may take some minutes to download the required docker images. When
done, you need to install vendors as follows:

```sh
docker-compose exec web bash
composer install
chown -R www-data:www-data .
```

When done, you need to execute the following commands in the web container:
- `php artisan key:generate`
- `php artisan jwt:secret`
- `php artisan l5-swagger:generate`
- `php artisan migrate`

**Change the hosts file to point the domain to your server.**

Windows: `c:\Windows\System32\Drivers\etc\hosts`

Linux: `/etc/hosts`

Add the following lines:

```
127.0.0.1  laravel-api.loc
```

After this steps, you can access your app from [http://laravel-api.loc:8080/](http://laravel-api.loc:8080/).
