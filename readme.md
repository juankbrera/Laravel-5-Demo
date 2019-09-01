# Coding Challenge

An API that allows the user to browse a product catalog and place purchase orders.


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for testing purposes.


### Prerequisites

You will need to make sure your machine meets the following requirements:

- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- MySQL or any other DB engine


### Installing

Installation steps:
- Go to the root directory, make a copy of the `.env.example` file and name it `.env`.
- Open the `.env` file and set the following variables according to your configuration: `APP_URL`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
- Run `composer install` to install the necessary dependencies.
- Run `php artisan key:generate` to set your application key to a random string.
- Run `php artisan migrate` to create the database tables.
- Run `php artisan passport:install` to create the encryption keys needed to generate secure access tokens.
- Run `php artisan migrate --seed` to populate the database with sample data. For testing purposes an admin user will be created at this point. The user will be `admin@admin.com` and the password will be `password`.

### Additional Information

- The database dump file is located at root directory, but if you run the database seeder it will not be necessary.
- The postman collection `coding_challenge.postman_collection.json` is located at root directory.


## Built With

* [Laravel](https://github.com/laravel/laravel) - A PHP framework for web artisans.
* [Laravel Passport](https://github.com/laravel/passport) - An OAuth2 server and API authentication package.
* [Revisionable](https://github.com/VentureCraft/revisionable) - Revision history for any laravel model.
* [Searchable](https://github.com/nicolaslopezj/searchable) - A search trait for Laravel.
* [Laravel Permission](https://github.com/spatie/laravel-permission) - Allows to manage user permissions and roles in a database.
* [Laravel-API-Exceptions](https://github.com/mlanin/laravel-api-exceptions) - Exception handler for JSON REST APIs on Laravel.
