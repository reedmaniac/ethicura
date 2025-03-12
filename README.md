
# Ethicura: Ethical Consumerism Application

The ethical consumerism app aims to empower individuals to make informed decisions about the food products they purchase by providing detailed insights into a product's certifications, nutrition, packaging, and corporate practices. By highlighting sustainable, ethical, and health-conscious alternatives, the app helps users align their purchases with their values.

This is essentially a backend service specifically geared for tracking the products and their data. Built from scratch by [Paul Burdick](https://github.com/reedmaniac).

## Development

### Stack

- [Laravel 12](https://laravel.com/)
- [Laravel Sail](https://laravel.com/docs/sail) - local development environment
- [Laravel Pint](https://laravel.com/docs/pint) - code styling
- [Vite v4](https://laravel.com/docs/vite) - JS/CSS assets
- [Tailwindcss v3.4](https://tailwindcss.com/) - frontend styling
- [Vue 3](https://vuejs.org/) and [Inertiajs](https://inertiajs.com/) - frontend framework
- [Ziggy](https://github.com/tighten/ziggy) - Vue/Laravel route binding
- [FontAwesome 6](https://docs.fontawesome.com/web/) - icons.


### Local Development

Docker config is managed by Laravel Sail defaults: https://laravel.com/docs/sail

- Ensure Docker is installed/configured on your system.
- Clone this repository
- Copy the .env file from example: `cp .env.example .env` and set DB_ variables
- Install composer dependencies:

```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

Configure a shell alias to look at the script within the ./vendor directory:

    alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'

Once dependencies have been installed bring the containers up with

    sail up -d

To run artisan commands log into the shell

    sail shell

Run the initial artisan commands

    php artisan key:generate
    php artisan storage:link
    php artisan migrate
    php artisan db:seed

To stop the containers

    sail stop

Compile js for local dev

    sail npm run dev

#### Emails

Emails sent using the configured Mailhog service can be viewed at: [http://127.0.0.1:8025](http://127.0.0.1:8025)

#### MySQL

The MySQL database is accessible at localhost port 3306 and the access credentials correspond to the values of your DB_USERNAME and DB_PASSWORD environment variables. Or, you may connect as the root user, which also utilizes the value of your DB_PASSWORD environment variable as its password.

#### Meilisearch

You may view the Meilisearch control panel at [http://localhost:7700](http://localhost:7700)

#### Redis

To connect to your application's Redis database from your local machine, you may use a graphical database management application such as [TablePlus](https://tableplus.com/). The Redis database is accessible at localhost port 6379.

### Code Styling

Just run `./vendor/bin/pint` within the Sail/Docker container and it should handle it all for you.


