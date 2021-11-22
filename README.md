## About Application

After a year working in development, I decided to build another todo app. I wanted to test my skills and show off what I've learned the past
year.
</br>
This is pure API application made in Laravel 8 framework.

## First start
This application uses Laravel Sail. Laravel Sail is a light-weight command-line interface for interacting with Laravel's default Docker development environment. 
Feel free to visit **[Official documentation](https://laravel.com/docs/8.x/sail)** for more info.

First copy .env.example file and rename it to .env  
`cp .env.example .env`  

You may install the application's dependencies by navigating to the application's directory and executing the following command. This command uses a small Docker container containing PHP and Composer to install the application's dependencies:

```
docker run --rm \
-u "$(id -u):$(id -g)" \
-v $(pwd):/var/www/html \
-w /var/www/html \
laravelsail/php80-composer:latest \
composer install --ignore-platform-reqs 
```

To start containers, run
```
./vendor/bin/sail up
```

Run migrations  
`./vendor/bin/sail artisan migrate`

## Executing artisan commands
By default, Sail commands are invoked using the `vendor/bin/sail` script that is included with all new Laravel applications:
```
./vendor/bin/sail artisan migrate
```

## API documentation
This application uses Scribe to build api documentation  
To generate files, run  
`./vendor/bin/sail artisan scribe:generate`

Documentation is visible on: `{APP_URL}/docs`
