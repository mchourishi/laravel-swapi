# SWAPI API with Laravel
This is a Laravel 7 based simple application that consumes SWAPI API.

## Description

The Application does the following:
- Lists characters of a film. 
- Lists Mammals.
- Import People to swapi_characters table.
- Taking Backup of swapi_characters table to the file passed via command.
- Update Characters from the update_characters table, this table is a pre-configuration and seeded by UpdatedCharacterDataSeeder.
- Backup Characters Post Update.
- Create New Character.

## Installation
- Run ``composer install``  and ``npm install`` to install dependencies. 
- Copy .env.example to .env and update database credentials and table.
- Run ``php artisan key:generate``
- Run ``php artisan migrate --seed`` to migrate and seed data.

### Usage
- Access index page (Eg: localhost/laravel-swapi/public/).
- Click on the tasks.

### Run Tests
- Run  ```vendor/bin/phpunit tests/``` from laravel-swapi directory.


