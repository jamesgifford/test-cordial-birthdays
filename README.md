# Cordial Take-Home Code Assessmemnt

Coding challenge from Cordial

## Description

My response to the take-home code assessment from Cordial

### Installation

* Clone the repo:
`git@github.com:jamesgifford/test-cordial-birthdays.git`

* Change to the project directory
`cd test-cordial-birthdays`

* Install dependencies
`composer install`

* Copy .env.example to .env
`cp .env.example .env`

* Update the database settings in .env with your MongoDB URI
eg: `DB_URI='mongodb+srv://username:password@cluster/myFirstDatabase?retryWrites=true&w=majority'`

* Migrate the database by running
`php artisan migrate`

* Serve the application by running:
`php -S localhost:8000 -t public`

* To add a person to the database make a POST call to the /api/person endpoint making sure to include the person's name, birthdate, and timezone:
eg: `curl -d '{"name":"John Smith", "birthdate":"1970-01-01", "timezone":"America/Los_Angeles"}' -H "Content-Type: application/json" -X POST http://localhost:8000/api/person`

* To view all people in the database make a GET call to either the /api/person or /api/people endpoint:
eg: `curl -H "Content-Type: application/json" -X GET http://localhost:8000/api/people`

* You can also specify a date for the interval when getting all people:
eg: `curl -d '{"date":"2050-01-01"}' -H "Content-Type: application/json" -X GET http://localhost:8000/api/person`

* To view a single person record from the database make a GET call to the /api/person/{person} endpoint and provide the id of the user:
eg: `curl -H "Content-Type: application/json" -X GET http://localhost:8000/api/person/617a4878bf668d0e5e6da923`

* You can also specify a date for the interval when getting a single person record:
eg: `curl -d '{"date":"2050-01-01"}' -H "Content-Type: application/json" -X GET http://localhost:8000/api/person/617a4878bf668d0e5e6da923`

* To delete a person record from the database make a DELETE call to the /api/person/{person} endpoint and provide the id of the user:
eg: `curl -H "Content-Type: application/json" -X DELETE http://localhost:8000/api/person/617a4878bf668d0e5e6da923`

* To run unit tests run:
`vendor/bin/phpunit`

&nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;

# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
